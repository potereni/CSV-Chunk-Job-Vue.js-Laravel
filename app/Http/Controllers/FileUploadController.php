<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FileChunk;
use App\Jobs\ProcessFileUpload;
use Illuminate\Support\Facades\DB;

class FileUploadController extends Controller
{
    public function upload(Request $request)
{
    $validator = Validator::make($request->all(), [
        'file' => 'required|file|max:500000',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $file = $request->file('file');

    $fileName = uniqid() . '_' . $file->getClientOriginalName();

    $file->storeAs('uploads', $fileName);

    ProcessFileUpload::dispatch($fileName);

    return response()->json(['message' => 'Файл успешно загружен и отправлен на обработку.']);
}

public function results(Request $request)
{
    $fileName = $request->input('fileName');

    $filePath = storage_path('app/uploads/' . $fileName);
    if (!file_exists($filePath)) {
        return response()->json(['message' => 'Файл не найден'], 404);
    }

    $result = DB::table('upload_results')->latest()->first();
    if ($result) {
        return response()->json([
            'correctCount' => $result->correct_count,
            'incorrectCount' => $result->incorrect_count
        ]);
    } else {
        return response()->json([
            'correctCount' => 0,
            'incorrectCount' => 0
        ]);
    }
}
}