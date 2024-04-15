<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileChunksTable extends Migration
{
    public function up()
    {
        Schema::create('file_chunks', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_chunks');
    }
}