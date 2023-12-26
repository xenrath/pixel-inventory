<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Barang extends Model
{
    use HasFactory;

        protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'gambar',
        'deskripsi',
        'tanggal_awal',
        ];

        public static function getId()
    {
        return $getId = DB::table('barangs')->orderBy('id', 'DESC')->take(1)->get();
    }
}