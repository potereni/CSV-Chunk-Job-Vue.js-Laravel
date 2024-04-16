<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncorrectCsvRecord extends Model
{
    protected $fillable = [
        // Добавьте поля для каждой ячейки CSV-файла
        'column1',
        'column2',
        // Продолжайте добавлять поля по мере необходимости
    ];
}