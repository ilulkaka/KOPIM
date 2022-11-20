<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelanjaModel extends Model
{
    protected $table = 'tb_trx_belanja';
    protected $primaryKey = 'id_trx_belanja';
    public $incrementing = false;
    protected $fillable = [
        'id_trx_belanja',
        'tgl_trx',
        'no_barcode',
        'nama',
        'nominal',
        'kategori',
        'inputor',
    ];
}
