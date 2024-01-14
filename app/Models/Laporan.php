<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Laporan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_laporan',
        'user_id',
        'keterangan',
        'tanggal_awal',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function getId()
    {
        return $getId = DB::table('laporans')->orderBy('id', 'DESC')->take(1)->get();
    }
}