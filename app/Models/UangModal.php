<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UangModal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_simpan',
        'nominal_uang',
        'keterangan'
    ];
    protected $primaryKey = 'id';
}
