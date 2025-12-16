<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Build;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::withTrashed()->find(Auth::id());
        $characters = $user->fetchCharacters();
        $sortTarget = $request['sort'] ?: 'experience';
        $sortReverse = isset($request['reverse']) ? true : false;

        usort($characters, function ($a, $b) use ($sortTarget, $sortReverse) {
            if ($sortReverse) {
                return $b[$sortTarget] <=> $a[$sortTarget];
            } else {
                return $a[$sortTarget] <=> $b[$sortTarget];
            }
        });

        $jsonPath = storage_path('app/data/poe/local/charsClasses.json');
        $classes = null;

        if (file_exists($jsonPath)) {
            $jsonData = file_get_contents($jsonPath);
            $classes = json_decode($jsonData, true);
        }

        return view('poe.characters.index', compact('characters', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $name)
    {
        $user = User::withTrashed()->find(Auth::id());
        $character = $user->fetchCharacterByName($name);

        $build = Build::where('poe_id', $character['id'])->first();

        return view('poe.characters.show', compact('character', 'build'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(string $name)
    {
        $user = User::withTrashed()->find(Auth::id());
        $character = $user->fetchCharacterByName($name);

        $fileName = $character['name'] . '.json';
        $fileContent = $character;

        return Response::make($fileContent, 200, [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
