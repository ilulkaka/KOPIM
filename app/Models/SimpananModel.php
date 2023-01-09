<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpananModel extends Model
{
    protected $table = 'tb_simpanan';
    protected $primaryKey = 'id_simpanan';
    public $incrementing = false;
    protected $fillable = [
        'id_simpanan',
        'no_anggota',
        'nama',
        'jenis_simpanan',
        'tgl_simpan',
        'jml_simpanan',
        'status_simpanan',
    ];
}
