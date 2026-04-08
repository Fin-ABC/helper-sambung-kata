<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kata extends Model
{
    use HasFactory;

    protected $table = 'kata';

    protected $fillable = [
        'kategori_id',
        'nama_awal',
        'is_used',
        'huruf_awal'
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
}
