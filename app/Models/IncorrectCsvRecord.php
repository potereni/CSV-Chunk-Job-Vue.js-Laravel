<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncorrectCsvRecord extends Model
{
    protected $fillable = ['column1', 'column2', 'row_index'];
}