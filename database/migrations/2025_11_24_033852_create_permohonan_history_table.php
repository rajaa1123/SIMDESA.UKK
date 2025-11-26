<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id')->constrained('permohonan')->onDelete('cascade');
            $table->foreignId('from_status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->foreignId('to_status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->foreignId('changed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_history');
    }
};