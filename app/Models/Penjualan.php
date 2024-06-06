<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nota',
        'tanggal_transaksi',
        'type_pembayaran',
        'total_produk',
        'grand_total',
        'type_pembayaran',
        'pembayaran',
        'kembalian',
        'keterangan'
    ];
    protected $primaryKey = 'id';

    public function detailPenjualans()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id', 'id');
    }

    public function bayarHutangs()
    {
        return $this->hasMany(BayarHutang::class, 'penjualan_id', 'id');
    }
}
