<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DataExportImportController extends Controller
{
    // Экспорт всех таблиц
    public function exportAll()
    {
        $tables = DB::select('SHOW TABLES');
        $zipFileName = storage_path('app/export_' . now()->format('Y-m-d') . '.zip');
        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE) !== TRUE) {
            return redirect()->back()->withErrors('Ошибка при создании архива');
        }

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $data = DB::table($tableName)->get();
            $jsonFileName = "{$tableName}.json";
            $zip->addFromString($jsonFileName, $data->toJson());
        }

        $zip->close();

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }

    // Импорт всех таблиц
    public function importAll(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->withErrors('Файл не загружен');
        }

        $zipFilePath = $request->file('file')->store('imports');
        $extractedPath = storage_path('app/imports/' . now()->format('Y-m-d_H-i-s'));
        $zip = new ZipArchive();

        if ($zip->open(storage_path('app/' . $zipFilePath)) === TRUE) {
            $zip->extractTo($extractedPath);
            $zip->close();
        } else {
            return redirect()->back()->withErrors('Не удалось открыть архив');
        }

        $files = array_diff(scandir($extractedPath), ['.', '..']);
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                $tableName = pathinfo($file, PATHINFO_FILENAME);
                if (DB::getSchemaBuilder()->hasTable($tableName)) {
                    $this->importDataFromJson($extractedPath . '/' . $file, $tableName);
                }
            }
        }

        File::deleteDirectory($extractedPath);

        return redirect()->back()->withSuccess('Данные успешно импортированы!');
    }

    // Экспорт одной таблицы
    public function exportTable(Request $request)
    {
        $table = $request->query('table');

        if (!DB::getSchemaBuilder()->hasTable($table)) {
            return redirect()->back()->withErrors('Таблица не найдена');
        }

        $data = DB::table($table)->get();
        $filePath = "exports/{$table}.json";
        Storage::disk('local')->put($filePath, $data->toJson());

        return response()->download(storage_path("app/{$filePath}"))->deleteFileAfterSend(true);
    }

    // Импорт данных в одну таблицу
    public function importTable(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->withErrors('Файл не загружен');
        }

        $file = $request->file('file');
        $jsonData = file_get_contents($file->getRealPath());
        $data = json_decode($jsonData, true);
        $table = $request->input('table');

        // Проверяем, существует ли таблица
        if (!DB::getSchemaBuilder()->hasTable($table)) {
            return redirect()->back()->withErrors('Таблица не найдена');
        }

        $columns = DB::getSchemaBuilder()->getColumnListing($table);

        DB::table($table)->delete();

        foreach ($data as $row) {
            $filteredRow = array_filter($row, fn($key) => in_array($key, $columns), ARRAY_FILTER_USE_KEY);
            if (!empty($filteredRow)) {
                DB::table($table)->insert($filteredRow);
            }
        }

        return redirect()->back()->withSuccess("Данные успешно импортированы в таблицу {$table}");
    }

    // Экспорт одной записи
    public function exportItem(Request $request)
    {
        $table = $request->query('table');
        $id = $request->query('id');

        // Проверяем, существует ли таблица
        if (!DB::getSchemaBuilder()->hasTable($table)) {
            return redirect()->back()->withErrors('Таблица не найдена');
        }

        // Получаем запись по идентификатору
        $record = DB::table($table)->find($id);

        if (!$record) {
            return redirect()->back()->withErrors('Запись не найдена');
        }

        // Формируем JSON-файл с данными
        $filePath = "exports/{$table}_record_{$id}.json";
        Storage::disk('local')->put($filePath, json_encode($record));

        return response()->download(storage_path("app/{$filePath}"));
    }

    // Импорт одной записи
    public function importItem(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->withErrors('Файл не загружен');
        }

        $file = $request->file('file');
        $jsonData = file_get_contents($file->getRealPath());
        $record = json_decode($jsonData, true);
        $table = $request->input('table');

        // Проверяем, существует ли таблица
        if (!DB::getSchemaBuilder()->hasTable($table)) {
            return redirect()->back()->withErrors('Таблица не найдена');
        }

        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        $filteredRecord = array_filter($record, function ($key) use ($columns) {
            return in_array($key, $columns);
        }, ARRAY_FILTER_USE_KEY);

        if (!empty($filteredRecord)) {
            DB::table($table)->insert($filteredRecord);
        }

        return redirect()->back()->withSuccess('Запись успешно импортирована в таблицу ' . $table);
    }

    // Импорт JSON данных в указанную таблицу
    private function importDataFromJson($filePath, $tableName)
    {
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);

        DB::table($tableName)->delete();

        foreach ($data as $row) {
            $filteredRow = array_filter($row, fn($key) => in_array($key, $columns), ARRAY_FILTER_USE_KEY);
            if (!empty($filteredRow)) {
                DB::table($tableName)->insert($filteredRow);
            }
        }
    }

    // Метод для генерации формы управления
    public function dashboard()
    {
        $tables = DB::select('SHOW TABLES');
        $html = '<h1>Трансфер базы данных</h1>';
        $html .= '<a href="/">Главная</a>';

        // Вывод сообщений об успехе или ошибке
        if (session('success')) {
            $html .= '<p style="color: green;">' . session('success') . '</p>';
        }
        if ($errors = session('errors')) {
            $html .= '<p style="color: red;">' . $errors->first() . '</p>';
        }

        $html .= '<hr>';

        $html .= '<h2>Все таблицы базы</h2>';

        // Форма для экспорта всех данных
        $html .= '<form action="' . route('data.export.all') . '" method="GET">';
        $html .= '<label>Экспорт всех данных:</label><br>';
        $html .= '<button type="submit">Экспортировать</button></form>';

        // Форма для импорта всех данных
        $html .= '<form action="' . route('data.import.all') . '" method="POST" enctype="multipart/form-data">';
        $html .= '<label>Импорт всех данных:</label><br>';
        $html .= '<input type="file" name="file">';
        $html .= '<button type="submit">Импортировать</button>';
        $html .= csrf_field() . '</form>';

        $html .= '<hr>';

        $html .= '<h2>Таблица базы данных</h2>';

        // Форма для экспорта одной таблицы
        $html .= '<form action="' . route('data.export.table') . '" method="GET">';
        $html .= '<label>Экспорт одной таблицы:</label><br>';
        $html .= '<select name="table">';

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $html .= "<option value='{$tableName}'>{$tableName}</option>";
        }

        $html .= '</select><button type="submit">Экспортировать</button></form>';

        // Форма для импорта одной таблицы
        $html .= '<form action="' . route('data.import.table') . '" method="POST" enctype="multipart/form-data">';
        $html .= '<label>Импорт одной таблицы:</label><br>';
        $html .= '<select name="table">';
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $html .= "<option value='{$tableName}'>{$tableName}</option>";
        }
        $html .= '</select>';
        $html .= '<input type="file" name="file">';
        $html .= '<button type="submit">Импортировать таблицу</button>';
        $html .= csrf_field() . '</form>';

        $html .= '<hr>';

        $html .= '<h2>Запись из таблицы</h2>';

        // Форма для экспорта одной записи
        $html .= '<form action="' . route('data.export.item') . '" method="GET">';
        $html .= '  <label>Экспорт одной записи:</label><br>';
        $html .= '  <select name="table">';
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $html .= '      <option value="' . $tableName . '">' . $tableName . '</option>';
        }
        $html .= '  </select>';
        $html .= '  <input type="number" name="id" placeholder="ID записи">';
        $html .= '  <button type="submit">Экспортировать запись</button>';
        $html .= '</form>';

        // Форма для импорта одной записи
        $html .= '<form action="' . route('data.import.item') . '" method="POST" enctype="multipart/form-data">';
        $html .= '<label>Импорт одной записи:</label><br>';
        $html .= '<select name="table">';
        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $html .= "<option value='{$tableName}'>{$tableName}</option>";
        }
        $html .= '</select>';
        $html .= '<input type="file" name="file">';
        $html .= '<button type="submit">Импортировать запись</button>';
        $html .= csrf_field() . '</form>';

        $html .= '<hr>';

        return $html;
    }
}
