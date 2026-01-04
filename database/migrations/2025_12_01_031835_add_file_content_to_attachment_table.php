<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attachment', function (Blueprint $table) {
            // Add LONGBLOB column to store file content
            $table->longText('file_content')->nullable()->after('file_path');
            
            // Make file_path nullable since we're storing in database
            $table->string('file_path', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('attachment', function (Blueprint $table) {
            $table->dropColumn('file_content');
            
            // Restore file_path to not nullable
            $table->string('file_path', 255)->nullable(false)->change();
        });
    }
};
