<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Detail_pengeluaran;
use App\Models\Pengeluaran;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $pengeluarans = Pengeluaran::query();

        if ($status) {
            $pengeluarans->where('status', $status);
        }

        if ($tanggal_awal && $tanggal_akhir) {
            $pengeluarans->whereBetween('tanggal_awal', [$tanggal_awal, $tanggal_akhir]);
        } elseif ($tanggal_awal) {
            $pengeluarans->where('tanggal_awal', '>=', $tanggal_awal);
        } elseif ($tanggal_akhir) {
            $pengeluarans->where('tanggal_awal', '<=', $tanggal_akhir);
        } else {
            $pengeluarans->whereDate('tanggal_awal', Carbon::today());
        }

        $pengeluarans->orderBy('id', 'DESC');
        $pengeluarans = $pengeluarans->get();

        return view('admin.pengeluaran.index', compact('pengeluarans'));
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

        return view('admin.pengeluaran.create', compact('saless', 'suppliers', 'barangs'));
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

        $pengeluaran = Pengeluaran::create([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $supplier->nama_supp,
            'telp' => $supplier->telp,
            'alamat' => $supplier->alamat,
            'user_id' => $request->user_id,
            'nama' => $sales->nama,
            'telp_sales' => $sales->telp,
            'alamat_sales' => $sales->alamat,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
            'kode_pengeluaran' => $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
        ]);

        if ($pengeluaran) {
            foreach ($request->barangs as $key => $value) {
                $barang = Barang::where('id', $value['id'])->first();
                Detail_pengeluaran::create([
                    'pengeluaran_id' => $pengeluaran->id,
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

        return redirect('admin/pengeluaran')->with('success', 'Berhasil menambah Pengeluaran');
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::where('id', $id)
            ->select('id', 'supplier_id', 'user_id', 'grand_total')
            ->first();
        $old_barangs = Detail_pengeluaran::where('pengeluaran_id', $id)
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

        return view('admin.pengeluaran.update', compact(
            'pengeluaran',
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
        $pengeluaran = Pengeluaran::where('id', $id)->update([
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

        if ($pengeluaran) {
            $barang_deleted = array_diff(
                Detail_pengeluaran::where('pengeluaran_id', $id)->pluck('barang_id')->toArray(),
                array_column($request->barangs, 'id')
            );

            if ($barang_deleted) {
                foreach ($barang_deleted as $value) {
                    Detail_pengeluaran::where([
                        ['pengeluaran_id', $id],
                        ['barang_id', $value]
                    ])->delete();
                }
            }

            foreach ($request->barangs as $key => $value) {
                $cek = Detail_pengeluaran::where([
                    ['pengeluaran_id', $id],
                    ['barang_id', $value['id']]
                ])->exists();
                if ($cek) {
                    Detail_pengeluaran::where([
                        ['pengeluaran_id', $id],
                        ['barang_id', $value['id']]
                    ])->update([
                        'harga' => $value['harga'],
                        'satuan' => $value['satuan'],
                        'jumlah' => $value['jumlah'],
                        'total' => $value['total']
                    ]);
                } else {
                    $barang = Barang::where('id', $value['id'])->first();
                    Detail_pengeluaran::create([
                        'pengeluaran_id' => $id,
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
        
        return redirect('admin/pengeluaran')->with('success', 'Berhasil memperbarui Pengeluaran');
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $detail_pengeluarans = Detail_pengeluaran::where('pengeluaran_id', $id)->get();

        foreach ($detail_pengeluarans as $detail_pengeluaran) {
            $jumlah = Barang::where('id', $detail_pengeluaran->barang_id)->value('jumlah');
            Barang::where('id', $detail_pengeluaran->barang_id)
                ->update([
                    'jumlah' => $jumlah + $detail_pengeluaran->jumlah
                ]);
            $detail_pengeluaran->delete();
        }

        $pengeluaran->delete();

        return redirect('admin/pengeluaran')->with('success', 'Berhasil menghapus pengeluaran');
    }

    public function cetakpdf($id)
    {
        $pengeluaran = Pengeluaran::where('id', $id)->select(
            'kode_pengeluaran',
            'user_id',
            'supplier_id',
            'tanggal',
            'grand_total',
        )
            ->with('supplier:id,kode_supplier,nama_supp,alamat,telp,hp,nama_bank,norek,atas_nama')
            ->with('user:id,nama')
            ->first();
        $details = Detail_pengeluaran::where('pengeluaran_id', $id)
            ->select(
                'nama_barang',
                'harga_pcs',
                'harga_dus',
                'harga_renceng',
                'harga_pack',
                'harga',
                'satuan',
                'jumlah',
                'total',
            )
            ->get();

        $pdf = PDF::loadView('admin.pengeluaran.cetak_pdf', compact('details', 'pengeluaran'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Pengeluaran_barang.pdf');
    }

    public function get_item($id)
    {
        $barang = Barang::where('id', $id)->first();
        return $barang;
    }

    public function delete_barang($id)
    {
        $item = Detail_pengeluaran::find($id);

        if ($item) {
            $pengeluaran = Pengeluaran::find($item->pengeluaran_id);

            if ($pengeluaran) {
                $grand = $pengeluaran->grand_total;
                $nominal = $item->total;
                $total = $grand - $nominal;
                $pengeluaran->update(['grand_total' => $total]);
            } else {
                return response()->json(['message' => 'Memo not found'], 404);
            }

            $barang = Barang::find($item->barang_id);

            if ($barang) {
                $barang->update(['jumlah' => $barang->jumlah + $item->jumlah]);
            } else {
                return response()->json(['message' => 'Barang not found'], 404);
            }

            $item->delete();

            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Detail pengeluaran not found'], 404);
        }
    }

    public function kode()
    {
        $item = Pengeluaran::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Pengeluaran::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        $tahun = date('y');
        $data = 'AK';
        $tanggal = date('dm');
        $kode_item = $data . "/" . $tanggal . $tahun . "/" . $num;

        return $kode_item;
    }

    // public function delete($id)
    // {
    //     $pengeluaran = Pengeluaran::find($id);
    //     $detailPengeluaran = Detail_pengeluaran::where('pengeluaran_id', $id)->get();

    //     foreach ($detailPengeluaran as $detail) {
    //         $barangId = $detail->barang_id;
    //         $barang = Barang::find($barangId);

    //         $newQuantity = $barang->jumlah + $detail->jumlah;
    //         $barang->update(['jumlah' => $newQuantity]);
    //     }
    //     $pengeluaran->detail_pengeluaran()->delete();
    //     $pengeluaran->delete();

    //     return redirect('admin/pengeluaran')->with('success', 'Berhasil menghapus pengeluaran');
    // }

    public function delete_item($id)
    {
        $detail = Detail_pengeluaran::where('id', $id);
        if ($detail->exists()) {
            $detail->delete();
        }

        return true;
    }
}
