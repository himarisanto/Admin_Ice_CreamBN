<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'kode_produk',
        'jumlah_masuk',
        'bonus',
        'harga_beli',
        'total_harga'
    ];
    protected $primaryKey = 'id';
    public function produks()
    {
        return $this->belongsTo(Ice::class, 'kode_produk', 'kode_produk');
    }


}
