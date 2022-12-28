<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamanModel extends Model
{
    protected $table = 'tb_pinjaman';
    protected $primaryKey = 'id_pinjaman';
    public $incrementing = false;
    protected $fillable = [
        'id_pinjaman',
        'no_pinjaman',
        'nik',
        'no_anggota',
        'nama',
        'jml_pinjaman',
        'tgl_realisasi',
        'tenor',
    ];
}
