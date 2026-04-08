<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kata', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel kategori. cascade = jika kategori dihapus, semua kata di dalamnya ikut terhapus
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('nama_kata');
            $table->boolean('is_used')->default(0); // 0 = belum dipakai, 1 = sudah dipakai
            $table->char('huruf_awal', 1); // Cukup 1 karakter, sangat hemat memori
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('katas');
    }
}
