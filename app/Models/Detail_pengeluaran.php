<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pengeluaran extends Model
{
    protected $fillable = [
        'pengeluaran_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
    ];
}