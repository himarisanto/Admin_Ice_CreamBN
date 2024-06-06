<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranKhusus extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_transaksi',
        'oleh',
        'nominal',
        'keperluan'
    ];

    protected $primaryKey = 'id';
}
