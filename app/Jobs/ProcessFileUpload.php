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
    // Путь к загруженному CSV файлу
    $filePath = storage_path('app/uploads/' . $this->fileName);
    
    // Создание Reader объекта для чтения CSV файла
    $reader = Reader::createFromPath($filePath);
    
    // Инициализируем счетчики правильных и неправильных записей
    $correctCount = 0;
    $incorrectCount = 0;
    
    // Чтение CSV файла
    foreach ($reader as $rowIndex => $row) {
        // Разбиваем строку на слова с помощью разделителя ";"
        $words = explode(';', $row[0]);
        
        // Проверка каждого слова в строке
        foreach ($words as $word) {
            // Удаление лишних пробелов в начале и конце слова
            $word = trim($word);

            // Проверка, содержит ли слово только буквы
            if (preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $word)) {
                // Если слово состоит только из букв, сохраняем его в таблицу "correct_csv_records"
                CorrectCsvRecord::create(['column1' => $word]);
                $correctCount++;
            } else {
                // Иначе сохраняем слово в таблицу "incorrect_csv_records" вместе с номером строки
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

    // Возвращаем результаты в формате JSON
    $results = [
        'correctCount' => $correctCount,
        'incorrectCount' => $incorrectCount
    ];

    return response()->json($results);
}
}