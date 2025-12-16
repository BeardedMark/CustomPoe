<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\Discord;


class AuthController extends Controller
{
    public function dashboard()
    {
        $user = User::find(Auth::id());
        $characters = $user->fetchCharacters();

        return view('auth.dashboard', compact('user', 'characters'));
    }

    public function login()
    {
        return view('auth.login');
    }

    public function enter(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::attempt($request->only('name', 'password'))) {
            return redirect()->route('auth.dashboard')->withSuccess('Вы авторизовались');
        }

        return redirect()->back()->withError('Данные не верны, не существуют или не подтверждены');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/')->withSuccess('Вы вышли из учетной записи');
    }
}
