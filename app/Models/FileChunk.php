<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileChunk extends Model
{
    protected $fillable = ['file_name', 'chunk_data'];
}