<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        if ($keyword) {
            $barangs = Barang::where('nama_barang', 'like', "%$keyword%")->paginate(10);
        } else {
            $barangs = Barang::paginate(10);
        }

        return view('sales.barang.index', compact('barangs'));
    }
}