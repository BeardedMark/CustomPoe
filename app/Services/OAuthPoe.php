<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class OAuthPoe
{
    protected $clientSecret;
    protected $email;
    protected $clientId;
    protected $redirectUri;

    protected $authorizationEndpoint = 'https://www.pathofexile.com/oauth/authorize';
    protected $tokenEndpoint = 'https://www.pathofexile.com/oauth/token';

    public function __construct()
    {
        $this->clientSecret = env('POE_OAUTH_CLIENT_SECRET');
        $this->email = env('POE_OAUTH_EMAIL');
        $this->clientId = env('POE_OAUTH_CLIENT_ID');
        $this->redirectUri = env('POE_OAUTH_REDIRECT_URI');
    }

    // Инициализация OAuth авторизации
    public function initiateAuthorization()
    {
        $state = bin2hex(random_bytes(16));
        $codeVerifier = bin2hex(random_bytes(32));
        $codeChallenge = strtr(rtrim(base64_encode(hash('sha256', $codeVerifier, true)), '='), '+/', '-_');

        session(['codeVerifier' => $codeVerifier]);

        $query = http_build_query([
            'client_id' => $this->clientId,
            'response_type' => 'code',
            'scope' => 'account:profile account:stashes account:characters',
            'state' => $state,
            'redirect_uri' => $this->redirectUri,
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
        ]);

        return "{$this->authorizationEndpoint}?{$query}";
    }

    // Обработка авторизации
    public function handleAuthorization($code)
    {
        $codeVerifier = session('codeVerifier');

        $response = Http::asForm()->withHeaders([
            'User-Agent' => env('POE_OAUTH_REDIRECT_URI')
        ])->post($this->tokenEndpoint, [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri,
            'code_verifier' => $codeVerifier,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Проверяем и создаем пользователя
            $username = $data['username'];
            $user = User::where('name', $username)->first();
            if (!$user) {
                $password = Str::random(32);
                $user = User::create([
                    'name' => $username,
                    'password' => Hash::make($password),
                ]);
            }

            // Авторизация пользователя
            Auth::login($user);

            // Сохранение токенов
            session([
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'token_expires_in' => time() + $data['expires_in'],
            ]);

            return redirect()->route('pages.main')->with('message', 'Авторизация успешна!');
        } else {
            return redirect()->route('pages.main')->with('error', 'Ошибка авторизации!');
        }
    }

    // Обновление access_token
    public function refreshToken()
    {
        $refreshToken = session('refresh_token');

        try {
            $response = Http::asForm()->withHeaders([
                'User-Agent' => "OAuth custompoe/1.0.0 ({$this->email})"
            ])->post($this->tokenEndpoint, [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            if ($response->successful()) {
                return $response->json();
            } else {
                throw new \Exception('Ошибка запроса: ' . $response->body());
            }

            if ($response->successful()) {
                $data = $response->json();
                session([
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'token_expires_in' => time() + $data['expires_in'],
                ]);
                return $data;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    // Проверка и обновление токена
    public function checkToken()
    {
        if (time() > session('token_expires_in')) {
            return $this->refreshToken();
        }
        return session('access_token');
    }

    // Универсальный метод выполнения запросов к Path of Exile API
    protected function makeApiRequest($endpoint)
    {
        $accessToken = $this->checkToken();
        $resource = "https://www.pathofexile.com/api";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$accessToken}",
                'User-Agent' => "OAuth custompoe/1.0.0 ({$this->email})"
            ])->get($resource . $endpoint);

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
    }


    public function getProfile()
    {
        return $this->makeApiRequest('/profile');
    }

    public function getLeagues()
    {
        return $this->makeApiRequest('/account/leagues');
    }

    public function getAllCharacters()
    {
        $data = $this->makeApiRequest('/character');
        $characters = null;

        if (isset($data['characters'])) {

            $characters = $data['characters'];
        }

        if(empty($characters)){
            $jsonPath = storage_path('app/data/poe/api/characters.json');

            if (file_exists($jsonPath)) {
                $jsonData = file_get_contents($jsonPath);
                $characters = json_decode($jsonData, true);
            }
        }

        foreach ($characters as $character) {
            if (isset($character['current']) && $character['current'] === true) {
                $user = User::find(Auth::id());

                $user->character = $character;
                $user->save();
            }
        }

        return $characters;
    }

    public function getCurrentCharacter()
    {
        $characters = $this->getAllCharacters();

        foreach ($characters as $character) {
            if (isset($character['current']) && $character['current'] === true) {
                return $character;
            }
        }

        return ['error' => 'Current character not found'];
    }

    public function getCharacterByName(string $characterName)
    {
        $data = $this->makeApiRequest('/character/' . $characterName);

        if (isset($data['character'])) {
            return $data['character'];
        }

        $jsonPath = storage_path('app/data/poe/api/characters/' . $characterName . '.json');

        if (file_exists($jsonPath)) {
            $jsonData = file_get_contents($jsonPath);
            return json_decode($jsonData, true)['character'];
        }

        return null;
    }

    public function getStashesByLeague(string $leagueName)
    {
        return $this->makeApiRequest('/stash/' . $leagueName);
    }

    public function getAllItemFilters()
    {
        return $this->makeApiRequest('/item-filter');
    }

    public function getItemFilterById(int $filterId)
    {
        return $this->makeApiRequest('/item-filter/' . $filterId);
    }
}
