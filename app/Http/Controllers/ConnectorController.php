<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConnectorController extends Controller
{
    protected $webhook = 'https://discord.com/api/webhooks/1273377609572683776/DsgRDqOr3UWSHfruUReCKzOIwdcqs0EsC13NhZwiu-J8fhTIMDI830wOqeHvDsgjiCW3';

    public function register(Request $request)
    {
        $request->validate([
            'login' => 'required|string|max:255',
            'profile' => 'required|string|max:255',
            'discord' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'content' => 'required|string|max:255',
        ]);

        $data = [
            'username' => 'CustomPoe.ru',
            'avatar_url' => 'https://custompoe.ru/img/decor/ascendancy.png',
            'content' => 'Запрос на регистрацию',
            'embeds' => [
                [
                    'fields' => [
                        [
                            'name' => 'Логин PoE',
                            'value' => $request['login'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Discord',
                            'value' => $request['discord'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Email',
                            'value' => $request['email'],
                            'inline' => true,
                        ],

                        [
                            'name' => 'Стаж игры',
                            'value' => $request['experience'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Уровень игры',
                            'value' => $request['level'],
                            'inline' => true,
                        ],
                        [
                            'name' => 'Любимый контент',
                            'value' => $request['content'],
                            'inline' => true,
                        ],
                    ]
                ]
            ],
        ];

        $response = Http::withoutVerifying()->post($this->webhook, $data);

        if (!$response->successful()) {
            return redirect()->back()->with('message',  $response->body());
        }
        return redirect()->route('auth.register')->withSuccess('Запрос отправлен');
    }
    
    public function feedback(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        $data = [
            'username' => 'CustomPoe.ru',
            'avatar_url' => 'https://custompoe.ru/img/decor/ascendancy.png',
            'content' => 'Обратная связь с сайта',
            'embeds' => [
                [
                    'title' => $request['name'],
                    'description' => $request['message']
                ]
            ],
        ];

        $response = Http::withoutVerifying()->post($this->webhook, $data);

        if (!$response->successful()) {
            return redirect()->route('auth.register')->with('message',  $response->body());
        }
        return redirect()->back()->withSuccess('Сообщение отправлено');
    }
}
