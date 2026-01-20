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
            $table->boolean('is_signed_electronically')->default(false);
            $table->string('digital_signature_hash')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropColumn(['is_signed_electronically', 'digital_signature_hash']);
        });
    }
};
