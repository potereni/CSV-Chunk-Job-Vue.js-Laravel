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
        // Создание таблицы для правильных записей
        Schema::create('correct_csv_records', function (Blueprint $table) {
            $table->id();
            // Добавьте столбцы для каждой ячейки CSV-файла
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            // Например: $table->string('column3')->nullable();
            $table->timestamps();
        });

        // Создание таблицы для неправильных записей
        Schema::create('incorrect_csv_records', function (Blueprint $table) {
            $table->id();
            // Добавьте столбцы для каждой ячейки CSV-файла
            $table->string('column1')->nullable();
            $table->string('column2')->nullable();
            // Например: $table->string('column3')->nullable();
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
        // Удаление таблицы для правильных записей
        Schema::dropIfExists('correct_csv_records');

        // Удаление таблицы для неправильных записей
        Schema::dropIfExists('incorrect_csv_records');
    }
}