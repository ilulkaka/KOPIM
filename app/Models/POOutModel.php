<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class POOutModel extends Model
{
    protected $table = 'tb_po_out';
    protected $primaryKey = 'id_po_out';
    public $incrementing = false;
    protected $fillable = [
        'id_po_out',
        'id_po',
        'tgl_po',
        'nomor_po',
        'item_cd',
        'nama',
        'spesifikasi',
        'qty_in',
        'qty_out',
        'satuan',
        'harga',
        'total',
        'nouki',
        'status_po',
        'no_dokumen',
        'tgl_kirim'
    ];
}
