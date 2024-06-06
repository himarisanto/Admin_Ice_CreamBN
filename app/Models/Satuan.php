<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;

    protected $fillable =[
        'nama_satuan',
        'keterangan'
    ];
    protected $primaryKey = 'id';

    public function Ices(){
        return $this->hasMany(Ice::class, 'id', 'satuan_id');
    }
}
