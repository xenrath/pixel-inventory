<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        return view('admin.barang.index');
    }

    public function create()
    {
        return view('admin.barang.create');
    }

    public function store(Request $request)
    {
    }

    public function edit()
    {
        return view('admin.barang.edit');
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
