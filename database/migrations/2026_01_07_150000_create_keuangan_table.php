<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->string('kategori'); // Dana Desa, ADD, PADes, Layanan, Operasional, dll.
            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('permohonan_id')->nullable(); // Relasi jika dari layanan
            $table->unsignedBigInteger('user_id'); // Siapa yang input
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('permohonan_id')->references('id')->on('permohonan')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
