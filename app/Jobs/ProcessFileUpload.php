<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;
use App\Models\CorrectCsvRecord;
use App\Models\IncorrectCsvRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProcessFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle(): JsonResponse
{
    $filePath = storage_path('app/uploads/' . $this->fileName);
    
    $reader = Reader::createFromPath($filePath);
    
    $correctCount = 0;
    $incorrectCount = 0;
    
    // Чтение CSV файла
    foreach ($reader as $rowIndex => $row) {
        $words = explode(';', $row[0]);
        
        foreach ($words as $word) {
            $word = trim($word);


            if (preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $word)) {
                CorrectCsvRecord::create(['column1' => $word]);
                $correctCount++;
            } else {
                IncorrectCsvRecord::create(['column1' => $word, 'column2' => $rowIndex]);
                $incorrectCount++;
            }
        }
    }

    DB::table('upload_results')->insert([
        'correct_count' => $correctCount,
        'incorrect_count' => $incorrectCount,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $results = [
        'correctCount' => $correctCount,
        'incorrectCount' => $incorrectCount
    ];

    return response()->json($results);
}
}