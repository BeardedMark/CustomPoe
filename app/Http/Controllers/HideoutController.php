<?php

namespace App\Http\Controllers;

use App\Models\Hideout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class HideoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hideouts = Hideout::getSearch($request->all())
            ->orderBy('updated_at', 'desc')
            ->get();
        // $info = 'Список всех убежищь изгнанников которые размещены на сайте';

        return view('resources.hideouts.index', compact('hideouts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.hideouts.create');
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
            'name' => 'required|string|max:255|unique:hideouts,name'
        ]);

        $filter = Hideout::create([
            'name' => $validateData['name'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('hideouts.edit', $filter)->withSuccess('Убежище создано');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hideouts = Hideout::inRandomOrder()->take(3)->get();
        $hideout = Hideout::withTrashed()->find($id);

        $hideout->incrementViews();
        $doodads = $hideout->getDoodadsItem();
        return view('resources.hideouts.show', compact('hideout', 'hideouts', 'doodads'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hideout = Hideout::withTrashed()->find($id);
        $users = User::withTrashed()->get();

        if (Auth::user() != $hideout->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для редактирования чужого Убежища');

        return view('resources.hideouts.edit', compact('hideout', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hideout = Hideout::withTrashed()->find($id);

        if (Auth::user() != $hideout->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для обновления чужого Убежища');

        $request->validate([
            'name' => 'required|string|max:255|unique:hideouts,name,' . $hideout->id,
        ]);

        $hideout->update($request->all());

        return redirect()->route('hideouts.show', $hideout)->withSuccess('Убежище обновлёно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hideout $hideout)
    {
        if (Auth::user() != $hideout->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для удаления чужого Убежища');

        $hideout->delete();

        return redirect()->back()->withSuccess('Убежище удалёно');
    }

    public function restore($id)
    {
        $hideout = Hideout::onlyTrashed()->find($id);

        if (Auth::user() != $hideout->user() && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для восстановления чужого Убежища');

        if ($hideout) {
            $hideout->restore();
            return redirect()->back()->withSuccess('Убежище восстановлено');
        }

        return redirect()->back()->withError('Убежище не найдено');
    }

    public function download($id)
    {
        $hideout = Hideout::find($id);

        $fileName = $hideout->name . '.hideout';
        $fileContent = $hideout->text;

        $hideout->incrementDownloads();

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
