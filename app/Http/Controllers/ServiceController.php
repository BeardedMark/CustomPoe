<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $services = Service::getSearch($request->all())
            ->orderBy('updated_at', 'desc')
            ->get();

        $types = (new Service())->types();
        return view('resources.services.index', compact('services', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.services.create');
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
            'name' => 'required|string|max:255|unique:services,name'
        ]);

        $filter = Service::create([
            'name' => $validateData['name'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('services.edit', $filter)->withSuccess('Объявление создано');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $services = Service::inRandomOrder()->take(3)->get();
        $service = Service::withTrashed()->find($id);

        $service->incrementViews();
        return view('resources.services.show', compact('service', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $service = Service::withTrashed()->find($id);
        $users = User::withTrashed()->get();

        if (Auth::user() != $service->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для редактирования чужого Объявления');

        return view('resources.services.edit', compact('service', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $service = Service::withTrashed()->find($id);

        if (Auth::user() != $service->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для обновления чужого Объявления');

        $request->validate([
            'name' => 'required|string|max:255|unique:services,name,' . $service->id,
        ]);

        $service->update($request->all());

        return redirect()->route('services.show', $service)->withSuccess('Объявление обновлёно');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if (Auth::user() != $service->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для удаления чужого Объявления');

        $service->delete();

        return redirect()->back()->withSuccess('Объявление удалёно');
    }

    public function restore($id)
    {
        $service = Service::onlyTrashed()->find($id);

        if (Auth::user() != $service->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для восстановления чужого Объявления');

        if ($service) {
            $service->restore();
            return redirect()->back()->withSuccess('Объявление восстановлено');
        }

        return redirect()->back()->withError('Объявление не найдено');
    }

    public function whisp($id)
    {
        $service = Service::find($id);
        $service->incrementWhisps();
    }
}
