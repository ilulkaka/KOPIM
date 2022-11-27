<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $fillable = [
        'id_barang',
        'kode',
        'nama',
        'spesifikasi',
        'supplier',
        'harga',
    ];
}
