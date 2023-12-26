<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_pemasukan extends Model
{
    protected $fillable = [
        'pemasukan_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'jumlah',
    ];
}