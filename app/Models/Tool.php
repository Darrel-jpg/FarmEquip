<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $table = 'tools';
    protected $fillable = ['nama_alat', 'nama_kategori', 'harga_per_hari', 'status'];
}
