<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use App\Services\OAuthPoe;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',

        'is_admin',
        'character',
        'language',

        'content',
        'comment',
        'avatar',
        'wallpaper',
        'description',
        'gallery',
        'tags',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    function role()
    {
        // if ($this->is_admin) {
        //     return "Администратор";
        // }

        $stats = [
            'Фильтровщик' => count($this->filters()),
            'Строитель' => count($this->hideouts()),
            'Торговец' => count($this->services()),
            'Тренер' => count($this->builds())
        ];

        $maxValue = max($stats);

        $maxKeys = array_keys($stats, $maxValue);

        if (array_sum($stats) == 0) {
            return "Гость";
        }

        if (count($maxKeys) >= 3) {
            return "Контентмейкер";
        }

        if (count($maxKeys) == 2) {
            return ucfirst($maxKeys[0]) . '-' . ucfirst($maxKeys[1]);
        }

        if (count($maxKeys) == 1) {
            return ucfirst($maxKeys[0]);
        }
    }

    public function createdDays()
    {
        $createdAt = $this->created_at;

        $now = Carbon::now();

        $diffInDays = floor($createdAt->diffInDays($now));

        return $diffInDays;
    }

    public function filters($limit = null)
    {
        $query = $this->hasMany(Filter::class);
        return $limit ? $query->take($limit)->get() : $query->get();
    }

    public function builds($limit = null)
    {
        $query = $this->hasMany(Build::class);
        return $limit ? $query->take($limit)->get() : $query->get();
    }

    public function services($limit = null)
    {
        $query = $this->hasMany(Service::class);
        return $limit ? $query->take($limit)->get() : $query->get();
    }

    public function hideouts($limit = null)
    {
        $query = $this->hasMany(Hideout::class);
        return $limit ? $query->take($limit)->get() : $query->get();
    }

    public function contents()
    {
        $services = count($this->services());
        $filters = count($this->filters());
        $hideouts = count($this->hideouts());
        $builds = count($this->builds());

        $result = $services + $filters + $hideouts + $builds;
        return $result;
    }

    public function views()
    {
        $services = $this->services()->sum('views');
        $filters = $this->filters()->sum('views');
        $hideouts = $this->hideouts()->sum('views');
        $builds = $this->builds()->sum('views');

        $result = $services + $filters + $hideouts + $builds;
        return $result;
    }

    public function downloads()
    {
        $filters = $this->hasMany(Filter::class)->sum('downloads');
        $hideouts = $this->hasMany(Hideout::class)->sum('downloads');

        $result = $filters + $hideouts;
        return $result;
    }

    public function whisps()
    {
        $services = $this->hasMany(Service::class)->sum('whisps');

        return $services;
    }

    public function buildings()
    {
        $services = $this->hasMany(Build::class)->sum('buildings');

        return $services;
    }

    public function experience()
    {
        $experience = $this->views() + ($this->downloads() * 3) + ($this->whisps() * 3) + ($this->buildings() * 3);
        return $experience;
    }

    public function level()
    {
        $experience = $this->experience();

        $level = 1;
        $baseExperience = 10;

        while ($experience >= $baseExperience * pow($level, 2)) {
            $level++;
        }

        return $level;
    }

    public function experienceToNextLevel()
    {
        $currentExperience = $this->experience();
        $currentLevel = $this->level();
        $baseExperience = 10;

        // Опыт, необходимый для следующего уровня
        $experienceForNextLevel = $baseExperience * pow($currentLevel, 2);

        // Сколько опыта не хватает до следующего уровня
        return $experienceForNextLevel - $currentExperience;
    }

    public function experiencePerDay()
    {
        $currentExperience = $this->experience();

        // Текущая дата и время
        $now = now();

        // Время создания пользователя
        $createdAt = $this->created_at;

        // Разница во времени в минутах между созданием и текущим моментом
        $minutesSinceCreation = $createdAt->diffInDays($now);

        // Если пользователь создан только что, чтобы избежать деления на 0
        if ($minutesSinceCreation == 0) {
            return 0;
        }

        // Вычисляем опыт в минуту
        return round($currentExperience / $minutesSinceCreation, 0);
    }

    // Пример запроса к API Path of Exile с использованием access_token
    public function getProfile()
    {
        $accessToken = session('access_token'); // Проверяем и обновляем токен при необходимости

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}",
            'User-Agent' => "OAuth custompoe/1.0.0 ({$this->email})"
        ])->get('https://www.pathofexile.com/api/profile');

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to fetch profile'], 500);
        }
    }

    // Метод для получения всех персонажей
    public function getAllCharacters()
    {
        $accessToken = session('access_token'); // Проверка и обновление токена при необходимости

        // Запрос к API для получения всех персонажей
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$accessToken}",
            'User-Agent' => "OAuth custompoe/1.0.0 ({$this->email})"
        ])->get('https://www.pathofexile.com/api/character', [
            'accountName' => "BeardedMark"
        ]);

        return $response->json();
    }

    // Метод для получения текущего персонажа
    public function getCurrentCharacter()
    {
        // Получаем всех персонажей
        $characters = $this->getAllCharacters();

        if (isset($characters['error'])) {
            return $characters; // Если была ошибка, возвращаем её
        }

        // Ищем текущего персонажа
        foreach ($characters as $character) {
            if (isset($character['current']) && $character['current'] === true) {
                return $character; // Возвращаем текущего персонажа
            }
        }

        return ['error' => 'Current character not found'];
    }
    public function fetchProfile()
    {
        $oauthPoe = new OAuthPoe();
        return $oauthPoe->getProfile();
    }

    public function fetchLeagues()
    {
        $oauthPoe = new OAuthPoe();
        return $oauthPoe->getLeagues();
    }

    public function fetchCharacters()
    {
        $oauthPoe = new OAuthPoe();
        $chars = $oauthPoe->getAllCharacters();

        return $chars;
    }

    public function fetchCurrentCharacter()
    {
        $oauthPoe = new OAuthPoe();
        return $oauthPoe->getCurrentCharacter();
    }

    public function fetchCharacterByName(string $name)
    {
        $oauthPoe = new OAuthPoe();
        return $oauthPoe->getCharacterByName($name);
    }

    public function fetchItemFilters()
    {
        $oauthPoe = new OAuthPoe();
        return $oauthPoe->getAllItemFilters();
    }

    public function getCharacters()
    {
        $accountName = preg_replace('/\s+/', '', $this->name);

        // Формируем URL для запроса списка персонажей (публичный профиль)
        $url = "https://www.pathofexile.com/character-window/get-characters?accountName={$accountName}";

        // Отправляем GET-запрос
        $response = Http::withoutVerifying()->get($url);

        // Обрабатываем ошибки, которые могут возникнуть при запросе
        if ($response->status() === 401) {
            return ['error' => 'Sign-in is required (401).'];
        } elseif ($response->status() === 403) {
            return ['error' => "Account profile {$accountName} is private (403)"];
        } elseif ($response->status() === 404) {
            return ['error' => 'Account name is incorrect (404).'];
        } elseif (!$response->successful()) {
            return ['error' => 'Error retrieving character list: ' . $response->status()];
        }

        // Преобразуем ответ в JSON
        $characterList = $response->json();

        // Если список персонажей пуст, возвращаем соответствующее сообщение
        if (empty($characterList)) {
            return ['error' => 'The account has no characters to import.'];
        }

        // Если успешно получили список персонажей, возвращаем его
        return $characterList;
    }

    public function getPublicCharacters()
    {
        $profileUrl = "https://www.pathofexile.com/account/view-profile/{$this->name}/characters";

        $response = Http::withoutVerifying()->get($profileUrl);

        if ($response->successful()) {
            // Парсим HTML-ответ и ищем нужные данные
            $body = $response->body();
            // Можно использовать регулярные выражения или DOM-парсер для извлечения данных
            // Пример регулярного выражения для поиска имени персонажа:
            preg_match_all('/"character-name">([^<]+)<\/span>/', $body, $matches);

            if (!empty($matches[1])) {
                $characterNames = $matches[1]; // Массив с именами персонажей
                return response()->json($characterNames);
            }

            return response()->json(['error' => 'No characters found or profile is private'], 404);
        }

        return response()->json(['error' => 'Failed to retrieve profile page ' . $response->status()], $response->status());
    }
}
