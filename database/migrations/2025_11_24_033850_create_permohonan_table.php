<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->datetime('tanggal_pengajuan')->useCurrent();
            $table->foreignId('status_id')->constrained('status');
            $table->text('keterangan')->nullable();
            $table->string('nomor_resi', 50)->unique()->nullable();
            $table->datetime('tanggal_selesai')->nullable();
            $table->foreignId('processor_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('biaya_admin', 12, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan');
    }
};