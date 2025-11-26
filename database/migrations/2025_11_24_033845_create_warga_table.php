<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('jenis_kelamin', 20)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 50)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('jenis_pekerjaan', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('status_hidup', 20)->nullable();
            $table->string('status_domisili', 30)->nullable();
            $table->string('status_perkawinan', 50)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->foreignId('kartu_keluarga_id')->nullable()->constrained('kartu_keluarga')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warga');
    }
};