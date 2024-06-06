<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriUang extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_transaksi',
        'nota',
        'type',
        'kategori',
        'jumlah_uang'
    ];
    protected $primaryKey = 'id';
}
