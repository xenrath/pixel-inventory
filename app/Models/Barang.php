<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Barang extends Model
{
    use HasFactory;
    use LogsActivity;
    
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'harga_pcs',
        'harga_dus',
        'harga_renceng',
        'harga_pack',
        'gambar',
        'deskripsi',
        'tanggal_awal',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public static function getId()
    {
        return $getId = DB::table('barangs')->orderBy('id', 'DESC')->take(1)->get();
    }
}