<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FileChunk;
use App\Jobs\ProcessFileUpload;

class FileUploadController extends Controller
{
    public function upload(Request $request)
{
    // Валидация запроса
    $validator = Validator::make($request->all(), [
        'file' => 'required|file|max:500000', // Максимальный размер файла: 100 МБ
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Получение файла из запроса
    $file = $request->file('file');

    // Генерация уникального имени для файла
    $fileName = uniqid() . '_' . $file->getClientOriginalName();

    // Сохранение файла на сервере
    $file->storeAs('uploads', $fileName);

    // Отправка задачи в очередь на обработку файла
    ProcessFileUpload::dispatch($fileName);

    return response()->json(['message' => 'Файл успешно загружен и отправлен на обработку.']);
}

public function results(Request $request)
{
    // Получение результатов загрузки
    $chunks = FileChunk::all();

    return response()->json(['chunks' => $chunks]);
}
public function getUpload()
{
    // Возвращаем какие-то данные или сообщение
    return response()->json(['message' => 'GET-запрос к /api/upload успешно обработан']);
}
}