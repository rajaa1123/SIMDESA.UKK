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
        Schema::table('permohonan', function (Blueprint $table) {
            // Data surat yang diisi warga saat mengajukan permohonan
            $table->string('surat_nama')->nullable()->after('keterangan')
                ->comment('Nama lengkap untuk dicetak di surat (diisi warga)');
            $table->string('surat_nik', 16)->nullable()->after('surat_nama')
                ->comment('NIK untuk dicetak di surat');
            $table->string('surat_tempat_lahir')->nullable()->after('surat_nik');
            $table->date('surat_tanggal_lahir')->nullable()->after('surat_tempat_lahir');
            $table->enum('surat_jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable()->after('surat_tanggal_lahir');
            $table->string('surat_agama')->nullable()->after('surat_jenis_kelamin');
            $table->string('surat_pekerjaan')->nullable()->after('surat_agama');
            $table->text('surat_alamat')->nullable()->after('surat_pekerjaan');
            $table->string('surat_rt', 3)->nullable()->after('surat_alamat');
            $table->string('surat_rw', 3)->nullable()->after('surat_rt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn([
                'surat_nama',
                'surat_nik',
                'surat_tempat_lahir',
                'surat_tanggal_lahir',
                'surat_jenis_kelamin',
                'surat_agama',
                'surat_pekerjaan',
                'surat_alamat',
                'surat_rt',
                'surat_rw',
            ]);
        });
    }
};
