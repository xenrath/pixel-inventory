<?php

namespace App\Http\Controllers\Admin;


use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {

        $suppliers = Supplier::all();
        return view('admin/supplier.index', compact('suppliers'));
    }

    public function create()
    {

        return view('admin/supplier.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_supp' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $kode = $this->kode();

        Supplier::create(array_merge(
            $request->all(),
            [
                'kode_supplier' => $this->kode(),
            ]
        ));

        return redirect('admin/supplier')->with('success', 'Berhasil menambahkan supplier');
    }


    public function edit($id)
    {
        $supplier = Supplier::where('id', $id)->first();
        return view('admin/supplier.update', compact('supplier'));
    }

    public function show($id)
    {

        $supplier = Supplier::where('id', $id)->first();
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_supp' => 'required',
                'alamat' => 'required',
            ],
            [
                'nama_supp.required' => 'Masukkan nama supplier',
                'alamat.required' => 'Masukkan Alamat',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->errors()->all();
            return back()->withInput()->with('error', $error);
        }

        $supplier = Supplier::findOrFail($id);

        $supplier->nama_supp = $request->nama_supp;
        $supplier->alamat = $request->alamat;
        $supplier->telp = $request->telp;
        $supplier->nama_bank = $request->nama_bank;
        $supplier->atas_nama = $request->atas_nama;
        $supplier->norek = $request->norek;

        $supplier->save();

        return redirect('admin/supplier')->with('success', 'Berhasil memperbarui supplier');
    }

    public function kode()
    {
        $item = Supplier::all();
        if ($item->isEmpty()) {
            $num = "000001";
        } else {
            $id = Supplier::getId();
            foreach ($id as $value);
            $idlm = $value->id;
            $idbr = $idlm + 1;
            $num = sprintf("%06s", $idbr);
        }
        $tahun = date('y');
        $data = 'AS';
        $tanggal = date('dm');
        $kode_item = $data . "/" . $tanggal . $tahun . "/" . $num;

        return $kode_item;
    }

    public function destroy($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect('admin/supplier')->with('success', 'Berhasil menghapus supplier');
    }
}