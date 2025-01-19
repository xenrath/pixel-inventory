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
        $saless = User::where('role', 'sales')
            ->select('id', 'nama', 'alamat')
            ->orderBy('nama')
            ->take(10)
            ->get();
        $suppliers = Supplier::select('id', 'nama_supp', 'alamat')
            ->orderBy('nama_supp')
            ->take(10)
            ->get();
        $barangs = Barang::select(
            'id',
            'nama_barang',
            'harga_pcs',
            'harga_dus',
            'harga_renceng',
            'harga_pack'
        )
            ->orderBy('nama_barang')
            ->take(10)
            ->get();

        return view('admin.pemasukan.create', compact('saless', 'suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'user_id' => 'required',
            'barangs' => 'required',
            'grand_total' => 'required',
        ], [
            'supplier_id.required' => 'Supplier belum dipilih!',
            'user_id.required' => 'Sales belum dipilih!',
            'grand_total.required' => 'Grand total kosong!',
            'barangs.required' => 'Barang belum ditambahkan!',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $kode = $this->kode();
        $supplier = Supplier::where('id', $request->supplier_id)
            ->select('nama_supp', 'telp', 'alamat')
            ->first();
        $sales = User::where('id', $request->user_id)
            ->select('nama', 'telp', 'alamat')
            ->first();
        $format_tanggal = Carbon::now()->translatedFormat('d F Y');
        $tanggal = Carbon::now()->format('Y-m-d');

        $pemasukan = Pemasukan::create([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $supplier->nama_supp,
            'telp' => $supplier->telp,
            'alamat' => $supplier->alamat,
            'user_id' => $request->user_id,
            'nama' => $sales->nama,
            'telp_sales' => $sales->telp,
            'alamat_sales' => $sales->alamat,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
            'kode_pemasukan' => $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
        ]);

        if ($pemasukan) {
            foreach ($request->barangs as $key => $value) {
                $barang = Barang::where('id', $value['id'])->first();
                Detail_pemasukan::create([
                    'pemasukan_id' => $pemasukan->id,
                    'barang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'harga' => $value['harga'],
                    'satuan' => $value['satuan'],
                    'jumlah' => $value['jumlah'],
                    'total' => $value['total'],
                ]);
            }
        }

        return redirect('admin/pemasukan')->with('success', 'Berhasil menambah Pemasukan');
    }

    public function edit($id)
    {
        $pemasukan = Pemasukan::where('id', $id)
            ->select('id', 'supplier_id', 'user_id', 'grand_total')
            ->first();
        $old_barangs = Detail_pemasukan::where('pemasukan_id', $id)
            ->select(
                'barang_id as id',
                'nama_barang',
                'harga',
                'satuan',
                'jumlah',
                'total',
            )
            ->get();
        $saless = User::where('role', 'sales')
            ->select('id', 'nama', 'alamat')
            ->orderBy('nama')
            ->take(10)
            ->get();
        $suppliers = Supplier::select('id', 'nama_supp', 'alamat')
            ->orderBy('nama_supp')
            ->take(10)
            ->get();
        $barangs = Barang::select(
            'id',
            'nama_barang',
            'harga_pcs',
            'harga_dus',
            'harga_renceng',
            'harga_pack'
        )
            ->orderBy('nama_barang')
            ->take(10)
            ->get();

        return view('admin.pemasukan.update', compact(
            'pemasukan',
            'old_barangs',
            'saless',
            'suppliers',
            'barangs'
        ));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'user_id' => 'required',
            'barangs' => 'required',
            'grand_total' => 'required',
        ], [
            'supplier_id.required' => 'Supplier belum dipilih!',
            'user_id.required' => 'Sales belum dipilih!',
            'grand_total.required' => 'Grand total kosong!',
            'barangs.required' => 'Barang belum ditambahkan!',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $supplier = Supplier::where('id', $request->supplier_id)
            ->select('nama_supp', 'telp', 'alamat')
            ->first();
        $sales = User::where('id', $request->user_id)
            ->select('nama', 'telp', 'alamat')
            ->first();
        $pemasukan = Pemasukan::where('id', $id)->update([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $supplier->nama_supp,
            'telp' => $supplier->telp,
            'alamat' => $supplier->alamat,
            'user_id' => $request->user_id,
            'nama' => $sales->nama,
            'telp_sales' => $sales->telp,
            'alamat_sales' => $sales->alamat,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
        ]);

        if ($pemasukan) {
            $barang_deleted = array_diff(
                Detail_pemasukan::where('pemasukan_id', $id)->pluck('barang_id')->toArray(),
                array_column($request->barangs, 'id')
            );

            if ($barang_deleted) {
                foreach ($barang_deleted as $value) {
                    Detail_pemasukan::where([
                        ['pemasukan_id', $id],
                        ['barang_id', $value]
                    ])->delete();
                }
            }

            foreach ($request->barangs as $key => $value) {
                $cek = Detail_pemasukan::where([
                    ['pemasukan_id', $id],
                    ['barang_id', $value['id']]
                ])->exists();
                if ($cek) {
                    Detail_pemasukan::where([
                        ['pemasukan_id', $id],
                        ['barang_id', $value['id']]
                    ])->update([
                        'harga' => $value['harga'],
                        'satuan' => $value['satuan'],
                        'jumlah' => $value['jumlah'],
                        'total' => $value['total']
                    ]);
                } else {
                    $barang = Barang::where('id', $value['id'])->first();
                    Detail_pemasukan::create([
                        'pemasukan_id' => $id,
                        'barang_id' => $barang->id,
                        'kode_barang' => $barang->kode_barang,
                        'nama_barang' => $barang->nama_barang,
                        'harga_pcs' => $barang->harga_pcs,
                        'harga_dus' => $barang->harga_dus,
                        'harga_renceng' => $barang->harga_renceng,
                        'harga_pack' => $barang->harga_pack,
                        'harga' => $value['harga'],
                        'satuan' => $value['satuan'],
                        'jumlah' => $value['jumlah'],
                        'total' => $value['total'],
                    ]);
                }
            }
        }

        return redirect('admin/pemasukan')->with('success', 'Berhasil memperbarui Pemasukan');
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
