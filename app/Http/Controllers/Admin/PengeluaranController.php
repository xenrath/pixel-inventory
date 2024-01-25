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
        $sales = User::all();
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('admin.pengeluaran.create', compact('sales', 'suppliers', 'barangs'));
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

        $pengeluaran = Pengeluaran::create([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $request->nama_supp,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'telp_sales' => $request->telp_sales,
            'alamat_sales' => $request->alamat_sales,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
            'kode_pengeluaran' => $kode,
            'tanggal' => $format_tanggal,
            'tanggal_awal' => $tanggal,
        ]);

        if ($pengeluaran) {
            foreach ($data_pembelians as $data_pesanan) {
                $barang = Barang::where('id', $data_pesanan['id'])->first();

                Detail_pengeluaran::create([
                    'pengeluaran_id' => $pengeluaran->id,
                    'barang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang,
                    'harga_pcs' => $barang->harga_pcs,
                    'harga_dus' => $barang->harga_dus,
                    'harga_renceng' => $barang->harga_renceng,
                    'harga_pack' => $barang->harga_pack,
                    'satuan' => $barang->satuan,
                    'jumlah' => $data_pesanan['jumlah'],
                    'total' => $data_pesanan['total'],
                ]);

                $jumlah_barang = $barang->jumlah - $data_pesanan['jumlah'];

                Barang::where('id', $data_pesanan['id'])->update([
                    'jumlah' => $jumlah_barang
                ]);
            }
        }

        return redirect('admin/pengeluaran')->with('success', 'Berhasil menambah pengeluaran');
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

    public function edit($id)
    {

        $pengeluaran = Pengeluaran::where('id', $id)->first();
        $details = Detail_pengeluaran::where('pengeluaran_id', $id)->get();
        $sales = User::all();
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        return view('admin.pengeluaran.update', compact('details', 'pengeluaran', 'sales', 'suppliers', 'barangs'));
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

        $transaksi = Pengeluaran::findOrFail($id);

        if ($request->has('barang_id')) {
            for ($i = 0; $i < count($request->barang_id); $i++) {
                $validator_produk = Validator::make($request->all(), [
                    'barang_id.' . $i => 'required',
                    'kode_barang.' . $i => 'required',
                    'nama_barang.' . $i => 'required',
                    'harga_pcs.' . $i => 'required',
                    'harga_dus.' . $i => 'required',
                    'satuan.' . $i => 'required',
                    'jumlah.' . $i => 'required',
                    'total.' . $i => 'required',
                ]);

                if ($validator_produk->fails()) {
                    $error_pesanans[] = "Barang nomor " . ($i + 1) . " belum dilengkapi!";
                }

                $barang_id = $request->barang_id[$i] ?? '';
                $kode_barang = $request->kode_barang[$i] ?? '';
                $nama_barang = $request->nama_barang[$i] ?? '';
                $harga_pcs = $request->harga_pcs[$i] ?? '';
                $harga_dus = $request->harga_dus[$i] ?? '';
                $satuan = $request->satuan[$i] ?? '';
                $jumlah = $request->jumlah[$i] ?? '';
                $total = $request->total[$i] ?? '';

                $data_pembelians->push([
                    'detail_id' => $request->detail_ids[$i] ?? null,
                    'barang_id' => $barang_id,
                    'kode_barang' => $kode_barang,
                    'nama_barang' => $nama_barang,
                    'harga_pcs' => $harga_pcs,
                    'harga_dus' => $harga_dus,
                    'satuan' => $satuan,
                    'jumlah' => $jumlah,
                    'total' => $total
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

        // format tanggal indo
        $tanggal1 = Carbon::now('Asia/Jakarta');
        $format_tanggal = $tanggal1->format('d F Y');

        $tanggal = Carbon::now()->format('Y-m-d');
        $barangs = Pengeluaran::findOrFail($id);

        // Update the main transaction
        $barangs->update([
            'supplier_id' => $request->supplier_id,
            'nama_supp' => $request->nama_supp,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'telp_sales' => $request->telp_sales,
            'alamat_sales' => $request->alamat_sales,
            'grand_total' =>  str_replace('.', '', $request->grand_total),
        ]);

        $barang_id = $barangs->id;

        $detailIds = $request->input('detail_ids');

        // foreach ($data_pembelians as $data_pesanan) {
        //     $detailId = $data_pesanan['detail_id'];

        //     if ($detailId) {
        //         Detail_pengeluaran::where('id', $detailId)->update([
        //             'pengeluaran_id' => $barangs->id,
        //             'barang_id' => $data_pesanan['barang_id'],
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
        //             'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
        //             'satuan' => $data_pesanan['satuan'],
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'total' => str_replace('.', '', $data_pesanan['total']),
        //         ]);
        //     } else {
        //         $existingDetail = Detail_pengeluaran::where([
        //             'pengeluaran_id' => $barangs->id,
        //             'barang_id' => $data_pesanan['barang_id'],
        //             'kode_barang' => $data_pesanan['kode_barang'],
        //             'nama_barang' => $data_pesanan['nama_barang'],
        //             'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
        //             'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
        //             'satuan' => $data_pesanan['satuan'],
        //             'jumlah' => $data_pesanan['jumlah'],
        //             'total' => str_replace('.', '', $data_pesanan['total']),
        //         ])->first();

        //         if (!$existingDetail) {
        //             Detail_pengeluaran::create([
        //                 'pengeluaran_id' => $barangs->id,
        //                 'barang_id' => $data_pesanan['barang_id'],
        //                 'kode_barang' => $data_pesanan['kode_barang'],
        //                 'nama_barang' => $data_pesanan['nama_barang'],
        //                 'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
        //                 'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
        //                 'satuan' => $data_pesanan['satuan'],
        //                 'jumlah' => $data_pesanan['jumlah'],
        //                 'total' => str_replace('.', '', $data_pesanan['total']),
        //             ]);
        //         }
        //     }
        // }

        foreach ($data_pembelians as $data_pesanan) {
            $detailId = $data_pesanan['detail_id'];

            if ($detailId) {
                $detailToUpdate = Detail_pengeluaran::find($detailId);

                if ($detailToUpdate) {
                    $jumlahLamaDetail = $detailToUpdate->jumlah;
                    $jumlahBaruDetail = $data_pesanan['jumlah'];

                    $selisihStok = $jumlahBaruDetail - $jumlahLamaDetail;
                    $baranggs = Barang::find($detailToUpdate->barang_id);

                    if ($baranggs) {
                        $jumlahLamaBarang = $baranggs->jumlah;
                        $jumlahBaruBarang = $data_pesanan['jumlah'];
                        $jumlahTotalBarang = $jumlahLamaBarang - $selisihStok;

                        $detailToUpdate->update([
                            'pengeluaran_id' => $barangs->id,
                            'barang_id' => $data_pesanan['barang_id'],
                            'kode_barang' => $data_pesanan['kode_barang'],
                            'nama_barang' => $data_pesanan['nama_barang'],
                            'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
                            'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
                            'satuan' => $data_pesanan['satuan'],
                            'jumlah' => $data_pesanan['jumlah'],
                            'total' => str_replace('.', '', $data_pesanan['total']),
                        ]);

                        $baranggs->update([
                            'jumlah' => $jumlahTotalBarang,
                        ]);
                    }
                }
            } else {
                $existingDetail = Detail_pengeluaran::where([
                    'pengeluaran_id' => $barangs->id,
                    'barang_id' => $data_pesanan['barang_id'],
                    'kode_barang' => $data_pesanan['kode_barang'],
                    'nama_barang' => $data_pesanan['nama_barang'],
                    'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
                    'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
                    'satuan' => $data_pesanan['satuan'],
                    'jumlah' => $data_pesanan['jumlah'],
                    'total' => str_replace('.', '', $data_pesanan['total']),
                ])->first();

                if (!$existingDetail) {
                    Detail_pengeluaran::create([
                        'pengeluaran_id' => $barangs->id,
                        'barang_id' => $data_pesanan['barang_id'],
                        'kode_barang' => $data_pesanan['kode_barang'],
                        'nama_barang' => $data_pesanan['nama_barang'],
                        'harga_pcs' => str_replace('.', '', $data_pesanan['harga_pcs']),
                        'harga_dus' => str_replace('.', '', $data_pesanan['harga_dus']),
                        'satuan' => $data_pesanan['satuan'],
                        'jumlah' => $data_pesanan['jumlah'],
                        'total' => str_replace('.', '', $data_pesanan['total']),
                    ]);

                    $baranggs = Barang::find($data_pesanan['barang_id']);

                    if ($baranggs) {
                        $newQuantity = $baranggs->jumlah - $data_pesanan['jumlah'];
                        $newQuantity = max(0, $newQuantity);
                        $baranggs->update(['jumlah' => $newQuantity]);
                    }
                }
            }
        }
        return redirect('admin/pengeluaran')->with('success', 'Berhasil memperbarui pengeluaran');
    }

    public function cetakpdf($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $details = Detail_pengeluaran::where('pengeluaran_id', $pengeluaran->id)->get();

        $pdf = PDF::loadView('admin.pengeluaran.cetak_pdf', compact('details', 'pengeluaran'));
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('Pengeluaran_barang.pdf');
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

    public function delete($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        $detailPengeluaran = Detail_pengeluaran::where('pengeluaran_id', $id)->get();

        foreach ($detailPengeluaran as $detail) {
            $barangId = $detail->barang_id;
            $barang = Barang::find($barangId);

            $newQuantity = $barang->jumlah + $detail->jumlah;
            $barang->update(['jumlah' => $newQuantity]);
        }
        $pengeluaran->detail_pengeluaran()->delete();
        $pengeluaran->delete();

        return redirect('admin/pengeluaran')->with('success', 'Berhasil menghapus pengeluaran');
    }

    // public function destroy($id)
    // {
    //     $pengeluaran = Pengeluaran::find($id);
    //     $pengeluaran->detail_pengeluaran()->delete();
    //     $pengeluaran->delete();

    //     return redirect('admin/pengeluaran')->with('success', 'Berhasil menghapus pengeluaran');
    // }
}
