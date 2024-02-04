<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pemasukan;
use App\Models\Pemasukan;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $pemasukans = Pemasukan::query();

        if ($status) {
            $pemasukans->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $pemasukans->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $pemasukans->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $pemasukans->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            $pemasukans->whereDate('tanggal_awal', Carbon::today());
        }

        $pemasukans->orderBy('id', 'DESC');
        $pemasukans = $pemasukans->get();

        return view('admin.pemasukan.index', compact('pemasukans'));
    }

    public function create()
    {
        $sales = User::where('role', 'sales')->get();
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('admin.pemasukan.create', compact('sales', 'suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $validasi_barang = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'user_id' => 'required',
            'grand_total' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
            'user_id.required' => 'Pilih nama sales!',
            'grand_total.required' => 'Grand total kosong!',
        ]);

        $error_barangs = array();

        if ($validasi_barang->fails()) {
            array_push($error_barangs, $validasi_barang->errors()->all()[0]);
        }

        $error_pesanans = array();
        $data_pembelians = collect();

        if ($request->has('id')) {
            foreach ($request->id as $key => $id) {
                $validator_produk = Validator::make($request->all(), [
                    'harga.' . $id => 'required',
                    'jumlah.' . $id => 'required',
                ]);

                if ($validator_produk->fails()) {
                    $error_pesanans[] = "Barang nomor " . ($key + 1) . " belum dilengkapi!";
                }

                $harga = $request->harga[$id] ?? '';
                $satuan = $request->satuan[$id] ?? '';
                $jumlah = $request->jumlah[$id] ?? '';
                $total = $request->total[$id] ?? '';

                $barang = Barang::where('id', $id)->first();

                $data_pembelians->push([
                    'id' => $id,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'harga' => $harga,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        if ($error_barangs || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_barangs', $error_barangs)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        $kode = $this->kode();

        // tgl indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $pemasukan = Pemasukan::create([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $request->nama_supp,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'telp_sales' => $request->telp_sales,
            'alamat_sales' => $request->alamat_sales,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
            'kode_pemasukan' => $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
        ]);

        if ($pemasukan) {
            foreach ($data_pembelians as $data_pesanan) {
                $barang = Barang::where('id', $data_pesanan['id'])->first();
                Detail_pemasukan::create([
                    'pemasukan_id' => $pemasukan->id,
                    'barang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'total' => $data_pesanan['total'],
                ]);
            }
        }

        return redirect('admin/pemasukan')->with('success', 'Berhasil menambah pemasukan');
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::where('id', $id)->first();
        $details = Detail_pemasukan::where('pemasukan_id', $id)
            ->select(
                'id as detail_id',
                'barang_id as id',
                'nama_barang',
                'harga_pcs',
                'harga_dus',
                'harga_renceng',
                'harga_pack',
                'satuan',
                'jumlah',
                'total',
            )
            ->get();
        $detail_id_data = Detail_pemasukan::where('pemasukan_id', $id)->pluck('id', 'barang_id')->toArray();
        $sales = User::all();
        $suppliers = Supplier::all();
        $barangs = Barang::get();

        return view('admin.pemasukan.update', compact('details', 'detail_id_data', 'pemasukan', 'sales', 'suppliers', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $validasi_pelanggan = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'user_id' => 'required',
        ], [
            'supplier_id.required' => 'Pilih nama supplier!',
            'user_id.required' => 'Pilih nama sales!',
        ]);

        $error_pelanggans = array();
        $error_pesanans = array();
        $data_pembelians = collect();

        if ($validasi_pelanggan->fails()) {
            array_push($error_pelanggans, $validasi_pelanggan->errors()->all()[0]);
        }

        if ($request->has('id')) {
            foreach ($request->id as $key => $barang_id) {
                $validator_produk = Validator::make($request->all(), [
                    'harga.' . $barang_id => 'required',
                    'jumlah.' . $barang_id => 'required',
                ]);

                if ($validator_produk->fails()) {
                    $error_pesanans[] = "Barang nomor " . ($key + 1) . " belum dilengkapi!";
                }

                $harga = $request->harga[$barang_id] ?? '';
                $satuan = $request->satuan[$barang_id] ?? '';
                $jumlah = $request->jumlah[$barang_id] ?? '';
                $total = $request->total[$barang_id] ?? '';

                $barang = Barang::where('id', $barang_id)->first();

                $data_pembelians->push([
                    'id' => $barang_id,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'harga' => $harga,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        if ($validasi_pelanggan->fails() || $error_pesanans) {
            return back()
                ->withInput()
                ->with('error_pelanggans', $error_pelanggans)
                ->with('error_pesanans', $error_pesanans)
                ->with('data_pembelians', $data_pembelians);
        }

        Pemasukan::where('id', $id)->update([
            'grand_total' => $request->grand_total
        ]);

        foreach ($request->id as $barang_id) {
            $detail = Detail_pemasukan::where([
                ['pemasukan_id', $id],
                ['barang_id', $barang_id]
            ])->exists();
            if ($detail) {
                Detail_pemasukan::where([
                    ['pemasukan_id', $id],
                    ['barang_id', $barang_id]
                ])->update([
                    'satuan' => $request->satuan[$barang_id],
                    'jumlah' => $request->jumlah[$barang_id],
                    'total' => $request->total[$barang_id]
                ]);
            } else {
                $barang = Barang::where('id', $barang_id)->first();
                Detail_pemasukan::create([
                    'pemasukan_id' => $id,
                    'barang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'satuan' => $request->satuan[$barang_id],
                    'jumlah' => $request->jumlah[$barang_id],
                    'total' => $request->total[$barang_id],
                ]);
            }
        }

        return redirect('admin/pemasukan')->with('success', 'Berhasil memperbarui pemasukan');
    }

    public function destroy($id)
    {
        $pemasukan = Pemasukan::find($id);
        $pemasukan->detail_pemasukan()->delete();
        $pemasukan->delete();

        return redirect('admin/pemasukan')->with('success', 'Berhasil menghapus pemasukan');
    }

    public function cetakpdf($id)
    {
        $pemasukan = Pemasukan::find($id);
        $details = Detail_pemasukan::where('pemasukan_id', $pemasukan->id)->get();

        $pdf = PDF::loadView('admin.pemasukan.cetak_pdf', compact('details', 'pemasukan'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Pemasukan_barang.pdf');
    }

    public function kode()
    {
        $item = Pemasukan::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pemasukan::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        $tahun = date('y');
        $data = 'AP';
        $tanggal = date('dm');
        $kode_item = $data . "/" . $tanggal . $tahun . "/" . $num;

        return $kode_item;
    }

    public function get_item($id)
    {
        $barang = Barang::where('id', $id)->first();
        return $barang;
    }

    public function delete_item($id)
    {
        $detail = Detail_pemasukan::where('id', $id);
        if ($detail->exists()) {
            $detail->delete();
        }

        return true;
    }
}
