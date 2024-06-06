<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'penjualan_id',
        'kode_produk',
        'jumlah_keluar',
        'harga_jual',
        'total_harga'
    ];
    protected $primaryKey = 'id';
    public function produks()
    {
        return $this->belongsTo(Ice::class, 'kode_produk', 'kode_produk');
    }
    public function relasipenjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'id');
    }
}
