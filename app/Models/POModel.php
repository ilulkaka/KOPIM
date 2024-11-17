<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POModel extends Model
{
    protected $table = 'tb_po';
    protected $primaryKey = 'id_po';
    public $incrementing = false;
    protected $fillable = [
        'id_po',
        'tgl_po',
        'nomor_po',
        'item_cd',
        'nama',
        'spesifikasi',
        'qty',
        'satuan',
        'harga_po',
        'status_po',
    ];
}
