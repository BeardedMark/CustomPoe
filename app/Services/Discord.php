<?php

namespace App\Services;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Discord
{
    protected $webhook;
    protected $username;

    public function __construct()
    {
        $this->webhook = env('DISCORD_WEBHOOK_URL');
        $this->username = env('DISCORD_USERNAME');
    }

    public function sendMessage(string $data): bool
    {
        $data = [
            'content' => $data,
        ];

        $response = Http::post($this->webhook, $data);

        return $response->successful();
    }

    public function sendRegister(Request $request): bool|RedirectResponse
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
                        ],
                        [
                            'name' => 'Discord',
                            'value' => $request['discord'],
                        ],
                        [
                            'name' => 'Email',
                            'value' => $request['email'],
                        ],

                        [
                            'name' => 'Стаж игры',
                            'value' => $request['experience'],
                        ],
                        [
                            'name' => 'Уровень игры',
                            'value' => $request['level'],
                        ],
                        [
                            'name' => 'Любимый контент',
                            'value' => $request['content'],
                        ],
                    ]
                ]
            ],
        ];

        $response = Http::withoutVerifying()->post($this->webhook, $data);

        if (!$response->successful()) {
            return redirect()->back()->with('message',  $response->body());
        }
        return $response->successful();
    }
}
