<?php

namespace App\Http\Controllers;

use App\Models\Build;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Support\Facades\File;

class BuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $builds = Build::getSearch($request->all())
            ->orderBy('updated_at', 'desc')
            ->get();

        $classes = Build::classes();
        return view('resources.builds.index', compact('builds', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $characterName = $request['characterName'];
        return view('resources.builds.create', compact('characterName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        if ($user->contents() >= $user->level()) {
            return redirect()->back()->withErrors('Повысьте уровень сообщества до ' . $user->contents() + 1 . ' для создания новой записи (осталось ' . $user->experienceToNextLevel() . ' опыта)');
        }

        $validateData = $request->validate([
            'name' => 'required|string|max:255|unique:builds,name'
        ]);

        $character = $user->fetchCharacterByName($request->input('characterName'));

        if ($character['level'] < 90) {
            return redirect()->back()->withError('Персонаж должен достичь 90 уровня для публикации сборки');
        }

        $buildData = [
            'name' => $validateData['name'],
            'user_id' => Auth::id(),
            'poe_id' => $character['id'],
            'class' => $character['class'],
            'realm' => $character['realm'],
            'budget' => $character['level'],
            'league' => $character['league'],
            'version' => $character['metadata']['version'],
            'character' => json_encode($character, JSON_UNESCAPED_UNICODE),

            // 'equipment' => json_encode($character['equipment'] ?? null),
            // 'jewels' => json_encode($character['jewels'] ?? null),
            // 'passives' => json_encode($character['passives'] ?? null),
            // 'rucksack' => json_encode($character['rucksack'] ?? null),
        ];

        $build = Build::create($buildData);

        return redirect()->route('builds.edit', $build)->withSuccess('Сборка создана');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $builds = Build::inRandomOrder()->take(3)->get();
        $build = Build::withTrashed()->find($id);

        $build->incrementViews();
        return view('resources.builds.show', compact('build', 'builds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $build = Build::withTrashed()->find($id);
        $users = User::withTrashed()->get();

        if (Auth::user() != $build->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для редактирования чужой сборки');

        return view('resources.builds.edit', compact('build', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $build = Build::withTrashed()->find($id);

        if (Auth::user() != $build->user && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для обновления чужой сборки');

        $request->validate([
            'name' => 'nullable|string|min:10|max:255|unique:builds,name,' . $build->id,
        ]);
        
        if ($request->input('characterName')) {
            $user = User::find(Auth::id());
            $character = $user->fetchCharacterByName($request->input('characterName'));

            $buildData = [
                'class' => $character['class'],
                'league' => $character['league'],
                'version' => $character['metadata']['version'],
                'character' => $character,

                // 'equipment' => json_encode($character['equipment'] ?? null),
                // 'jewels' => json_encode($character['jewels'] ?? null),
                // 'passives' => json_encode($character['passives'] ?? null),
                // 'rucksack' => json_encode($character['rucksack'] ?? null),
            ];
            $build->update($buildData);
        } else {
            $build->update($request->all());
        }

        return redirect()->route('builds.show', $build)->withSuccess('Сборка обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Build $build)
    {
        //
    }
    
    public function building($id)
    {
        $build = Build::find($id);
        $build->incrementBuildings();
        $user = User::find(Auth::id());
        $characterName = $user->fetchCurrentCharacter()['name'];
        $character = $user->fetchCharacterByName($characterName);
    
        $buildSkills = $build->hashes();
        $charSkills = $character['passives']['hashes'];
        
        // Проверка на то, что массив $buildSkills не пуст
        if (count($buildSkills) > 0) {
            $commonElements = array_intersect($buildSkills, $charSkills);
            $percentage = round((count($commonElements) / count($buildSkills)) * 100);
        } else {
            $percentage = 0; // Если у билда нет навыков, процент ставим 0
        }
    
        return view('resources.builds.building', compact('build', 'character', 'percentage'));
    }
    
}
