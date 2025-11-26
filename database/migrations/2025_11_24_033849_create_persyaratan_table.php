<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persyaratan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->foreignId('dokumen_id')->constrained('dokumen')->onDelete('restrict');
            $table->boolean('wajib')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('persyaratan');
    }
};