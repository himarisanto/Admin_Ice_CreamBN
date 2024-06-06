<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ice extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'gambar_produk',
        'nama_produk',
        'satuan_id',
        'harga_beli',
        'harga_jual',
        'stok',
        'keterangan'
    ];

    public function relsatuan(){
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }
}
