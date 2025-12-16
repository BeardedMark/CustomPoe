<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all()->sortByDesc(function ($user) {
            return $user->experience();
        });

        return view('resources.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => [
                'required',
                'string',
                'unique:users,name',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                // 'min:8',            // Минимальная длина 8 символов
                // 'regex:/[a-z]/',    // Должен содержать хотя бы одну строчную букву
                // 'regex:/[A-Z]/',    // Должен содержать хотя бы одну заглавную букву
                // 'regex:/[0-9]/',    // Должен содержать хотя бы одну цифру
                // 'regex:/[@$!%*?&#]/' // Должен содержать хотя бы один специальный символ
            ]
        ]);

        $user = User::create([
            'name' => $validateData['name'],
            'password' => Hash::make($validateData['password']),
        ]);

        return redirect()->route('users.show', $user)->withSuccess('Пользователь создан');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::withTrashed()->find($id);

        return view('resources.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (Auth::id() != $id && !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для редактирования чужого профиля');

        $user = User::withTrashed()->find($id);
        return view('resources.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::id() != $id && !Auth::user()->is_admin) {
            return redirect()->back()->withError('Недостаточно прав для обновления чужого профиля');
        }

        $user = User::withTrashed()->find($id);

        $rules = [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:users,name,' . $user->id,
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
            ],
            'wallpaper' => 'nullable|string|max:255',
            'avatar' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:255',
        ];

        $validatedData = $request->validate($rules);

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('users.show', $user)->withSuccess('Пользователь обновлён');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (Auth::user() != $user || !Auth::user()->is_admin)
            return redirect()->back()->withError('Недостаточно прав для удаления чужого профиля');

        $user->delete();

        return redirect()->back()->withSuccess('Пользователь удалён');
    }

    public function restore($id)
    {
        if (Auth::id() != $id || !Auth::user()->is_admin) {
            return redirect()->back()->withError('Недостаточно прав для восстановления чужого профиля');
        }

        $user = User::onlyTrashed()->find($id);

        if ($user) {
            $user->restore();
            return redirect()->back()->withSuccess('Пользователь восстановлен');
        }

        return redirect()->back()->withError('Пользователь не найден');
    }
}
