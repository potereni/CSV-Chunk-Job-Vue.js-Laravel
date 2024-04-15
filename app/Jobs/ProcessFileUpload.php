<?php


namespace App\Jobs;

use App\Models\FileChunk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        // Получаем все чанки для данного файла
        $chunks = FileChunk::where('file_name', $this->fileName)->post();

        // Обработка каждого чанка
        $validChunks = 0;
        $errorChunks = [];

        foreach ($chunks as $chunk) {
            // Проверяем чанк на корректность
            if ($this->isValidChunk($chunk->chunk_data)) {
                $validChunks++;
            } else {
                $errorChunks[] = $chunk->chunk_data;
            }
        }

        // Выводим результаты
        $totalChunks = $chunks->count();
        $validPercentage = $totalChunks > 0 ? ($validChunks / $totalChunks) * 100 : 0;

        echo "Всего чанков: $totalChunks\n";
        echo "Количество успешно обработанных чанков: $validChunks\n";
        echo "Процент успешных чанков: $validPercentage%\n";

        echo "\nЧанки-ошибки:\n";
        foreach ($errorChunks as $errorChunk) {
            echo $errorChunk . "\n";
        }
    }

    protected function isValidChunk($data)
    {
        // Проверяем, содержит ли чанк только слова
        return preg_match('/^[a-zA-Z\s]+$/', $data);
    }
}