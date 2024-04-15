<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h1>File Upload</h1>

    <!-- Контейнер для результатов загрузки -->
    <div id="apps">
        <upload-form></upload-form>
        <upload-results></upload-results>
    </div>

    <!-- Подключаем скрипт Vue.js -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>