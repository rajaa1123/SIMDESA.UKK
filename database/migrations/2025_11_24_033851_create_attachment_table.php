<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attachment', function (Blueprint $table) {
            $table->id();
            $table->string('attachable_type', 50);
            $table->unsignedBigInteger('attachable_id');
            $table->foreignId('dokumen_id')->nullable()->constrained('dokumen')->onDelete('set null');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('file_path', 255);
            $table->string('nama_file', 255)->nullable();
            $table->string('mime', 100)->nullable();
            $table->integer('size')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('status')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['attachable_type', 'attachable_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attachment');
    }
};