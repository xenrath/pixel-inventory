<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Detail_pemasukan extends Model
{

    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'pemasukan_id',
        'barang_id',
        'kode_barang',
        'nama_barang',
        'harga_pcs',
        'harga_dus',
        'satuan',
        'jumlah',
        'total',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
}
