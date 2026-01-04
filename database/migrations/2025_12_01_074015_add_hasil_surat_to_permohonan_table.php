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
            $table->longText('hasil_surat_file')->nullable()->after('rejection_reason')
                ->comment('Base64 encoded PDF file of result letter');
            $table->string('hasil_surat_filename')->nullable()->after('hasil_surat_file')
                ->comment('Original filename of uploaded result letter');
            $table->timestamp('hasil_surat_uploaded_at')->nullable()->after('hasil_surat_filename')
                ->comment('Timestamp when result letter was uploaded');
            $table->unsignedBigInteger('hasil_surat_uploaded_by')->nullable()->after('hasil_surat_uploaded_at')
                ->comment('User ID who uploaded the result letter (admin/kades)');
            
            $table->foreign('hasil_surat_uploaded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['hasil_surat_uploaded_by']);
            $table->dropColumn([
                'hasil_surat_file',
                'hasil_surat_filename',
                'hasil_surat_uploaded_at',
                'hasil_surat_uploaded_by'
            ]);
        });
    }
};
