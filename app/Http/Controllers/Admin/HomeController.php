<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $barang = Barang::count();
        $pemasukan = Pemasukan::count();
        $pengeluaran = Pengeluaran::count();

        return view('admin.index', compact('barang', 'pemasukan', 'pengeluaran'));
    }
}
