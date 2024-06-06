<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BayarHutang extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjualan_id',
        'tanggal_transaksi',
        'bayar',
        'oleh',
        'sisa',
        'keterangan'
    ];

    protected $primaryKey = 'id';

    public function relasipenjualan()
    {
        return $this->belongsTo(Penjualan::class,'penjualan_id','id',);
    }
}
