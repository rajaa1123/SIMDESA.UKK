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
            // Digital signature fields for Kepala Desa approval
            $table->text('kades_digital_signature')->nullable()->after('kades_note')
                ->comment('Encrypted digital signature payload (base64)');
            $table->string('kades_signature_qr_path')->nullable()->after('kades_digital_signature')
                ->comment('Path to QR code image containing signature');
            $table->timestamp('kades_signature_timestamp')->nullable()->after('kades_signature_qr_path')
                ->comment('Exact timestamp when digital signature was created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn([
                'kades_digital_signature',
                'kades_signature_qr_path',
                'kades_signature_timestamp'
            ]);
        });
    }
};
