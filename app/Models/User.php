<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use LogsActivity;
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'kode_user',
        'nama',
        'username',
        'telp',
        'alamat',
        'password',
        'role',
        'gambar'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function isAdmin()
    {
        if ($this->role == 'admin') {
            return true;
        }
        return false;
    }

    public function isSales()
    {
        if ($this->role == 'sales') {
            return true;
        }
        return false;
    }

    public static function getId()
    {
        return $getId = DB::table('users')->orderBy('id', 'DESC')->take(1)->get();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable('*');
    }
}