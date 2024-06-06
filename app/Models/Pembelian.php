<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $fillable = [
        'nota',
        'tanggal_transaksi',
        'type_pembayaran',
        'total_produk',
        'total_bonus',
        'grand_total',
        'pembayaran',
        'kembalian',
        'keterangan'
    ];
    protected $primaryKey = 'id';

    public function detailPembelians()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id', 'id');
    }


}
