<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InModel extends Model
{
    protected $table = 'tb_in';
    protected $primaryKey = 'id_in';
    public $incrementing = false;
    protected $fillable = ['id_in', 'kode', 'tgl_in', 'qty_in'];
}
