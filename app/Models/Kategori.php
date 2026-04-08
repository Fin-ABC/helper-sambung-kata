<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Menyesuaikan nama tabel secara eksplisit
    protected $table = 'kategori';

    // Kolom yang boleh diisi secara massal
    protected $fillable = ['nama'];

    // Relasi One-to-Many ke tabel kata
    public function kata()
    {
        return $this->hasMany(Kata::class);
    }
}
