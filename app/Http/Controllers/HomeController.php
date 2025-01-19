<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            return redirect('admin');
        } elseif (auth()->user()->isSales()) {
            return redirect('sales');
        }
    }

    public function supplier_search(Request $request)
    {
        $keyword = $request->keyword;
        $suppliers = Supplier::where('nama_supp', 'like', "%$keyword%")
            ->orWhere('alamat', 'like', "%$keyword%")
            ->select('id', 'nama_supp', 'alamat')
            ->orderBy('nama_supp')
            ->take(10)
            ->get();
        return $suppliers;
    }

    public function supplier_set($id)
    {
        $supplier = Supplier::where('id', $id)
            ->select('id', 'nama_supp', 'telp', 'alamat')
            ->first();

        return $supplier;
    }

    public function sales_search(Request $request)
    {
        $keyword = $request->keyword;
        $saless = User::where('role', 'sales')
            ->where(function ($query) use ($keyword) {
                $query->where('nama', 'like', "%$keyword%");
                $query->orWhere('alamat', 'like', "%$keyword%");
            })
            ->select('id', 'nama', 'alamat')
            ->orderBy('nama')
            ->take(10)
            ->get();
        return $saless;
    }

    public function sales_set($id)
    {
        $sales = User::where([
            ['role', 'sales'],
            ['id', $id]
        ])
            ->select('id', 'nama', 'telp', 'alamat')
            ->first();
        return $sales;
    }

    public function barang_search(Request $request)
    {
        $keyword = $request->keyword;
        $barangs = Barang::where('nama_barang', 'like', "%$keyword%")
            ->select(
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
        return $barangs;
    }

    public function barang_get($id)
    {
        $barang = Barang::where('id', $id)
            ->select('id', 'nama_barang')
            ->first();
        return $barang;
    }

    public function harga_get(Request $request, $id)
    {
        $satuan = $request->satuan;
        if ($satuan == 'pcs') {
            $harga = Barang::where('id', $id)->value('harga_pcs');
        } elseif ($satuan == 'dus') {
            $harga = Barang::where('id', $id)->value('harga_dus');
        } elseif ($satuan == 'renceng') {
            $harga = Barang::where('id', $id)->value('harga_renceng');
        } elseif ($satuan == 'pack') {
            $harga = Barang::where('id', $id)->value('harga_pack');
        } else {
            $harga = null;
        }
        return $harga;
    }
}
