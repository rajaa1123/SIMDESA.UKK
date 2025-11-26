<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_layanan', 255);
            $table->string('kategori', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('durasi_proses');
            $table->string('biaya', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('layanan');
    }
};