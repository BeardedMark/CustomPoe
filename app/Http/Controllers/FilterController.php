<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Services\ItemFilter;
use App\Services\Parser;

class FilterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = Filter::getSearch($request->all())
            ->orderBy('updated_at', 'desc')
            ->get();
        $autors = User::all();
        $fields = (new Filter())->getFillable();
        $search = $request->all();

        return view('resources.filters.index', compact('filters', 'search', 'autors', 'fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.filters.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        if ($user->contents() >= $user->level()) {
            return redirect()->back()->withErrors('Повысьте уровень для создания новой записи (до ' . $user->level() + 1 . ' уровня осталось ' . $user->experienceToNextLevel() . ' опыта)');
        }
        
        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:filters,name'
        ]);

        $filter = Filter::create([
            'name' => $validateData['name'],
            'realm' => 'ANY',
            'type' => 'Normal',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('filters.edit', $filter)->withSuccess('Фильтр создан');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $filters = Filter::inRandomOrder()->take(3)->get();
        $filter = Filter::withTrashed()->find($id);

        // $itemFilter = new ItemFilter($filter->filter);
        // $rules = $itemFilter->getPalette();

        $parser = new Parser();
        $lines = explode("\n", $filter->filter);
        $parser->parse($lines);
        $palette = $parser->getPalette();

        $filter->incrementViews();
        return view('resources.filters.show', compact('filter', 'filters', 'palette'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $filter = Filter::withTrashed()->find($id);
        $users = User::withTrashed()->get();

        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для редактирования чужого фильтра предметов');

        return view('resources.filters.edit', compact('filter', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $filter = Filter::withTrashed()->find($id);

        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для обновления чужого фильтра предметов');

        $request->validate([
            'name' => 'required|string|max:255|unique:filters,name,' . $filter->id,
            'description' => 'max:255',
            'version' => 'max:255',
            'type' => 'required|string|max:255',
            'realm' => 'required|string|max:255',
            'icon' => 'max:255',
            'wallpaper' => 'max:255',
            'link' => 'max:255',
            'webhook' => 'max:255',
            'user_id' => 'max:255',
            'downloads' => 'max:255',
        ]);

        $filter->update($request->all());

        return redirect()->route('filters.show', $filter)->withSuccess('Фильтр обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filter $filter)
    {
        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для удаления чужого фильтра предметов');

        $filter->delete();

        return redirect()->back()->withSuccess('Фильтр удалён');
    }

    public function restore($id)
    {
        $filter = Filter::onlyTrashed()->find($id);

        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для восстановления чужой записи');

        if ($filter) {
            $filter->restore();
            return redirect()->back()->withSuccess('Фильтр восстановлен');
        }

        return redirect()->back()->withError('Фильтр не найден');
    }

    public function download($id)
    {
        $filter = Filter::find($id);

        $fileName = $filter->name . '.filter';
        $fileContent = $filter->text;

        $filter->incrementDownloads();

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function export(Filter $filter)
    {
        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для экспорта чужой записи');

        $filter = Filter::find($filter->id);

        $fileName = $filter->name . '.Data.CustomPoe.json';
        $fileContent = $filter->toJson();

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }

    public function import(Request $request, Filter $filter)
    {
        if (Auth::user() != $filter->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для импорта чужой записи');

        // Валидация загруженного файла
        $request->validate([
            'file' => 'required|file|mimes:json',
        ]);

        // Загрузка файла
        $file = $request->file('file');

        // Получение содержимого файла
        $fileContent = file_get_contents($file->getRealPath());

        // Преобразование JSON в массив
        $data = json_decode($fileContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect()->back()->withErrors('Ошибка при разборе JSON файла.');
        }

        // Вызываем метод update, передавая данные
        return $this->update(new Request($data), $filter);
    }
}
