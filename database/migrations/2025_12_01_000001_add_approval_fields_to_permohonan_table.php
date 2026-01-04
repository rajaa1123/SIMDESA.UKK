<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            // Field untuk approval admin
            $table->foreignId('admin_user_id')->nullable()->after('processor_user_id')->constrained('users')->onDelete('set null');
            $table->datetime('admin_approval_date')->nullable()->after('admin_user_id');
            $table->text('admin_note')->nullable()->after('admin_approval_date');
            
            // Field untuk approval kepala desa
            $table->foreignId('kades_user_id')->nullable()->after('admin_note')->constrained('users')->onDelete('set null');
            $table->datetime('kades_approval_date')->nullable()->after('kades_user_id');
            $table->text('kades_note')->nullable()->after('kades_approval_date');
            
            // Field untuk tracking rejection
            $table->text('rejection_reason')->nullable()->after('kades_note');
            $table->enum('rejected_by', ['admin', 'kades'])->nullable()->after('rejection_reason');
        });
    }

    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['admin_user_id']);
            $table->dropForeign(['kades_user_id']);
            $table->dropColumn([
                'admin_user_id',
                'admin_approval_date',
                'admin_note',
                'kades_user_id',
                'kades_approval_date',
                'kades_note',
                'rejection_reason',
                'rejected_by'
            ]);
        });
    }
};
