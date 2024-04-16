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
            // Выводим отладочную информацию для каждой строки
            echo "Обработка строки $rowIndex: " . implode(', ', $row) . PHP_EOL;
        
            // Проверка, является ли строка правильной
            if ($this->isValidRow($row)) {
                // Увеличиваем счетчик правильных записей
                $correctCount++;
            } else {
                // Увеличиваем счетчик неправильных записей
                $incorrectCount++;
            }
        }
        
        // Выводим результаты
        echo "Количество правильных записей: $correctCount\n";
        echo "Количество неправильных записей: $incorrectCount\n";
    }
    protected function isValidRow($row)
    {
        // Если строка пустая, считаем ее неправильной
        if (empty($row)) {
            return false;
        }
    
        // Проверка каждой ячейки в строке
        foreach ($row as $cell) {
            // Проверка, содержит ли ячейка только слова
            if (!preg_match('/^[a-zA-Zа-яА-Я\s]+$/', $cell)) {
                // Если найдены недопустимые символы, считаем строку неправильной
                return false;
            }
        }
        // Если все ячейки в строке содержат только слова, считаем строку правильной
        return true;
    }
}