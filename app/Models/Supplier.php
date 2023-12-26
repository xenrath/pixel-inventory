<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_supplier',
        'nama_supp',
        'alamat',
        'telp',
        'nama_bank',
        'atas_nama',
        'norek',
        'tanggal_awal',
    ];

    public static function getId()
    {
        return $getId = DB::table('suppliers')->orderBy('id', 'DESC')->take(1)->get();
    }

}