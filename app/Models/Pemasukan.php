<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class Pemasukan extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'kode_pemasukan',
        'user_id',
        'supplier_id',
        'nama_supp',
        'telp',
        'alamat',
        'nama',
        'grand_total',
        'telp_sales',
        'alamat_sales',
        'keterangan',
        'tanggal',
        'tanggal_awal',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail_pemasukan()
    {
        return $this->hasMany(Detail_pemasukan::class);
    }

    public static function getId()
    {
        return $getId = DB::table('pemasukans')->orderBy('id', 'DESC')->take(1)->get();
    }
}