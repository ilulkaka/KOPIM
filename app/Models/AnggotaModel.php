<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    protected $fillable = [
        'id_anggota',
        'nama',
        'nik',
        'alamat',
        'no_telp',
        'status',
        'no_ktp',
    ];
}
