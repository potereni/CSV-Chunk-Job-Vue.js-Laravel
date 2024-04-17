<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadResultsTable extends Migration
{
    public function up()
    {
        Schema::create('upload_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('correct_count')->default(0);
            $table->unsignedBigInteger('incorrect_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_results');
    }
}