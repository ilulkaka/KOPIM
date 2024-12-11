<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPOModel extends Model
{
    protected $table = 'tb_master_po';
    protected $primaryKey = 'id_master_po';
    public $incrementing = false;
    protected $fillable = [
        'id_master_po',
        'item_cd',
        'nama',
        'spesifikasi',
        'harga',
        'satuan',
    ];
}
