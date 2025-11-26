<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('group_key', 50);
            $table->string('code', 50);
            $table->string('name', 100);
            $table->timestamps();
            
            $table->unique(['group_key', 'code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('status');
    }
};