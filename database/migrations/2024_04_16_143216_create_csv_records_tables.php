<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvRecordsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correct_csv_records', function (Blueprint $table) {
            $table->id();
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            $table->timestamps();
        });


        Schema::create('incorrect_csv_records', function (Blueprint $table) {
            $table->id();
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('correct_csv_records');
        Schema::dropIfExists('incorrect_csv_records');
    }
}