<?php

namespace App\Jobs;

use App\Models\CorrectCsvRecord;
use App\Models\IncorrectCsvRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\Csv\Reader;

class ProcessFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle()
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
        // Выводим отладочную информацию для каждого слова в строке
        foreach ($row as $word) {
            echo "Обработка слова \"$word\" в строке $rowIndex\n";
    
            // Проверка, является ли слово правильным
            if ($this->isValidWord($word)) {
                // Увеличиваем счетчик правильных слов
                $correctCount++;
            } else {
                // Увеличиваем счетчик неправильных слов
                $incorrectCount++;
            }
        }
    }
    
    // Выводим результаты
    echo "Количество правильных слов: $correctCount\n";
    echo "Количество неправильных слов: $incorrectCount\n";
}

protected function isValidWord($word)
{
    // Удаление лишних пробелов в начале и конце слова
    $word = trim($word);

    // Проверка, содержит ли слово только буквы
    if (preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $word)) {
        // Если слово состоит только из букв, считаем его правильным
        return true;
    } else {
        // Иначе считаем слово неправильным
        return false;
    }
}
}