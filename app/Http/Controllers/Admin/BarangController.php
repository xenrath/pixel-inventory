<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'jumlah.required' => 'Masukkan jumlah',
                'satuan.required' => 'Masukkan satuan',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return back()->withInput()->with('error', $errors);
        }

        if ($request->gambar) {
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'barang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = '';
        }

        Barang::create(array_merge(
            $request->all(),
            [
                'gambar' => $namaGambar,
                'kode_barang' => $this->kode(),
            ]
        ));

        return redirect('admin/barang')->with('success', 'Berhasil menambahkan barang');
    }

    public function kode()
    {
        $item = Barang::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Barang::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        // $tahun = date('y');
        $data = 'AB';
        // $tanggal = date('dm');
        $kode_item = $data . $num;

        return $kode_item;
    }


    public function edit($id)
    {
        $barang = Barang::where('id', $id)->first();
        return view('admin.barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_barang' => 'required',
                'jumlah' => 'required',
                'satuan' => 'required',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            ],
            [
                'nama_barang.required' => 'Masukkan nama barang',
                'jumlah.required' => 'Masukkan jumlah',
                'satuan.required' => 'Masukkan satuan',
                'gambar.image' => 'Gambar yang dimasukan salah!',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barang = Barang::findOrFail($id);

        if ($request->gambar) {
            Storage::disk('local')->delete('public/uploads/' . $barang->gambar);
            $gambar = str_replace(' ', '', $request->gambar->getClientOriginalName());
            $namaGambar = 'barang/' . date('mYdHs') . rand(1, 10) . '_' . $gambar;
            $request->gambar->storeAs('public/uploads/', $namaGambar);
        } else {
            $namaGambar = $barang->gambar;
        }

        $barang->nama_barang = $request->nama_barang;
        $barang->jumlah = $request->jumlah;
        $barang->satuan = $request->satuan;
        $barang->deskripsi = $request->deskripsi;
        $barang->gambar = $namaGambar;
        $barang->save();

        return redirect('admin/barang')->with('success', 'Berhasil mengubah barang');
    }

    public function stok(Request $request, $id)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'jumlah' => 'required',
            ],
            [
                'jumlah.required' => 'Masukkan jumlah',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $barang = Barang::findOrFail($id);
        $barang->update([
            'jumlah' => $request->jumlah
        ]);

        return redirect()->back()->with('success', 'Berhasil memperbarui stok');
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('admin/barang')->with('success', 'Berhasil menghapus barang');
    }
}