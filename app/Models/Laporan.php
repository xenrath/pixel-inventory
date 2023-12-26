<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Laporan extends Model
{

    protected $fillable = [
        'kode_laporan',
        'user_id',
        'keterangan',
        'tanggal_awal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('laporans')->orderBy('id', 'DESC')->take(1)->get();
    }
}