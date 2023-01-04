<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = false;
    protected $fillable = [
        'id_pembayaran',
        'no_pinjaman',
        'no_anggota',
        'nik',
        'nama',
        'jml_angsuran',
        'tgl_angsuran',
        'angsuran_ke',
        'status_angsuran',
    ];
}
