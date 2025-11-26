<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('no_kk', 20)->unique();
            $table->text('alamat')->nullable();
            $table->string('kepala_keluarga', 100)->nullable();
            $table->string('status', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kartu_keluarga');
    }
};