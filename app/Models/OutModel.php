<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutModel extends Model
{
    protected $table = 'tb_out';
    protected $primaryKey = 'id_out';
    public $incrementing = false;
    protected $fillable = ['id_out', 'kode', 'tgl_out', 'qty_out'];
}
