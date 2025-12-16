<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Build;
use App\Models\Filter;
use App\Models\Hideout;
use App\Models\User;
use App\Services\OAuthPoe;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    public function main(Request $request)
    {
        $oauthService = new OAuthPoe;

        if ($request->query('auth')) {
            // Инициируем авторизацию
            return redirect($oauthService->initiateAuthorization());
        }

        // Если был передан параметр code, значит пользователь был перенаправлен для авторизации
        if ($request->query('code')) {

            $authResult = $oauthService->handleAuthorization($request->query('code'));
            if ($authResult) {
                // Успешная авторизация
                return redirect()->route('pages.main')->with('message', 'Авторизация успешна!');
            } else {
                return redirect()->route('pages.main')->with('error', 'Ошибка авторизации!');
            }
        }

        $services = Service::orderBy('created_at', 'desc')->get();
        $builds = Build::orderBy('updated_at', 'desc')->get();
        $filters = Filter::orderBy('downloads', 'desc')->get();
        $hideouts = Hideout::orderBy('views', 'desc')->get();
        $users = User::all()->sortByDesc(function ($user) {
            return $user->experience();
        });

        $count = count($filters) + count($hideouts) + count($services) + count($builds);
        $views = $filters->sum('views') + $hideouts->sum('views') + $services->sum('views') + $builds->sum('views');
        $downloads = $filters->sum('downloads') + $hideouts->sum('downloads');
        $transactions = $services->sum('whisps');
        $pumpings = $builds->sum('buildings');

        return view('pages.main', compact('services', 'builds', 'filters', 'hideouts', 'users', 'views', 'downloads', 'count', 'transactions', 'pumpings'));
    }

    public function menu()
    {
        return view('pages.menu');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function community()
    {
        $users = User::all();
        $lastUsers = User::orderBy('created_at', 'desc')->take(9)->get();
        $topLevels = User::all()->sortByDesc(function ($user) {
            return $user->experience();
        })->take(3);

        return view('pages.community', compact('users', 'lastUsers', 'topLevels'));
    }

    public function passiveTree()
    {
        $tree = File::get(storage_path('app/data/poe/cdn/tree/data.json'));
        $jsonData = json_decode($tree);
        return response()->json($jsonData);
    }
}
