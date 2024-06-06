<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUang extends Model
{
    use HasFactory;
    protected $fillable = ['master_uang'];
    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($masterUang) {
            $masterUang->master_uang = $masterUang->master_uang ?? 0;
        });
    }
}
