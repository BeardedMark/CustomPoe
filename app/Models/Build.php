<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use stdClass;

class Build extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',

        'name',
        'description',
        'is_public',
        'data',

        'content',
        'comment',
        'tags',
        'icon',
        'wallpaper',
        'gallery',
        'webhook',
        'link',

        'budget',
        'currency',
        'character',
        'skill',

        'poe_id',
        'class',
        'realm',
        'league',
        'version',

        'equipment',
        'jewels',
        'passives',
        'rucksack',

        'hard',
        'life',
        'speed',
        'damage',

        'pros',
        'important',
        'cons',

        'pob',
        'three',
        'views',
        'buildings',
    ];


    public static function currencies()
    {
        return [
            'Mirror',
            'Divine',
            'Exaltet',
            'Chaos',
            'Alchemy',
            'Alteration',
        ];
    }
    public static function classes()
    {
        return [
            'Duelist',
            'Slayer',
            'Gladiator',
            'Champion',

            'Shadow',
            'Assassin',
            'Saboteur',
            'Trickster',

            'Marauder',
            'Juggernaut',
            'Berserker',
            'Chieftain',

            'Witch',
            'Necromancer',
            'Elementalist',
            'Occultist',

            'Ranger',
            'Deadeye',
            'Raider',
            'Pathfinder',

            'Templar',
            'Inquisitor',
            'Hierophant',
            'Guardian',

            'Scion',
            'Ascendant',
        ];
    }

    public static function getSearch(array $params)
    {
        $query = self::query();

        if (isset($params['autor'])) {
            $query->where('user_id', 'like', $params['autor']);
        }

        $searchableFields = (new static)->getFillable();

        $query->where(function ($query) use ($params, $searchableFields) {
            foreach ($params as $key => $param) {
                if (in_array($key, $searchableFields)) {
                    $query->orWhere($key, 'like', "%{$param}%");
                }
            }
        });

        if (isset($params['search'])) {
            $search = $params['search'];
            $searchableFields = (new static)->getFillable();

            $query->where(function ($query) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $query->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        if (isset($params['sort']) && !empty($params['sort']) && in_array($params['sort'], (new static)->getFillable())) {
            $direction = isset($params['reverse']) ? 'desc' : 'asc';

            if (isset($params['empty'])) {
                $query->whereNotNull($params['sort'])
                    ->where($params['sort'], '!=', '');
            }

            $query->orderBy($params['sort'], $direction);
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdAt()
    {
        $createdAt = $this->created_at;

        $now = Carbon::now();

        $diffInDays = floor($createdAt->diffInDays($now));

        if ($diffInDays == 0) {
            return "Сегодня";
        } elseif ($diffInDays == 1) {
            return "Вчера";
        } elseif ($diffInDays <= 7) {
            return "{$diffInDays} дн назад";
        } elseif ($diffInDays > 7) {
            return "Больше недели";
        } elseif ($diffInDays > 30) {
            return "Больше месяца";
        } elseif ($diffInDays > 365) {
            return "Больше года";
        }
        return $diffInDays;
    }

    public function updatedAt()
    {
        $updatedAt = $this->updated_at;

        $now = Carbon::now();

        $diffInDays = floor($updatedAt->diffInDays($now));

        if ($diffInDays == 0) {
            return "Сегодня";
        } elseif ($diffInDays == 1) {
            return "Вчера";
        } elseif ($diffInDays <= 7) {
            return "{$diffInDays} дн назад";
        } elseif ($diffInDays > 7) {
            return "Больше недели";
        } elseif ($diffInDays > 30) {
            return "Больше месяца";
        } elseif ($diffInDays > 365) {
            return "Больше года";
        }
        return $diffInDays;
    }

    public function pros()
    {
        return $this->pros ? explode("\n", $this->pros) : [];
    }

    public function important()
    {
        return $this->important ? explode("\n", $this->important) : [];
    }

    public function cons()
    {
        return $this->cons ? explode("\n", $this->cons) : [];
    }

    public function getLink(): ?stdClass
    {
        $info = new \stdClass();
        $url = $this->link;

        if (!isset($url)) {
            return null;
        }

        $parsedUrl = parse_url($url);
        $domain = $parsedUrl['host'] ?? null;
        $guarded = isset($parsedUrl['scheme']) && $parsedUrl['scheme'] === 'https';
        if (isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
            $favicon = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . '/favicon.ico';
        }

        $info->url = $url;
        $info->domain = $domain;
        $info->favicon = $favicon ?? null;
        $info->guarded = $guarded;

        return $info;
    }

    public function gallery()
    {
        return explode("\n", $this->gallery);;
    }

    public function incrementViews()
    {
        $this->timestamps = false;
        $this->increment('views');
        $this->timestamps = true;
    }

    public function incrementBuildings()
    {
        $this->timestamps = false;
        $this->increment('buildings');
        $this->timestamps = true;
    }



    public function character()
    {
        $character = json_decode($this->character, true);
        return $character;
    }

    public function class()
    {
        $character = $this->character();
        $class = $character['class'] ?? null;
        return $class;
    }

    public function passives()
    {
        $character = $this->character();
        $passives = $character['passives'] ?? [];
        return $passives;
    }

    public function hashes()
    {
        $passives = $this->passives();
        $hashes = $passives['hashes'] ?? [];
        return $hashes;
    }

    public function banditChoice()
    {
        $passives = $this->passives();
        $banditChoice = $passives['bandit_choice'] ?? [];
        return $banditChoice;
    }

    public function pantheonMajor()
    {
        $passives = $this->passives();
        $pantheonMajor = $passives['pantheon_major'] ?? [];
        return $pantheonMajor;
    }

    public function pantheonMinor()
    {
        $passives = $this->passives();
        $pantheonMinor = $passives['pantheon_minor'] ?? [];
        return $pantheonMinor;
    }

    public function rucksack()
    {
        $character = $this->character();
        $rucksack = $character['rucksack'] ?? [];
        return $rucksack;
    }

    public function jewels()
    {
        $character = $this->character();
        return $character['jewels'] ?? [];
    }

    public function equipment()
    {
        $character = $this->character();
        $equipment = $character['equipment'] ?? [];
        return $equipment;
    }

    public function armor()
    {
        $equipment = $this->equipment();

        $filteredArray = array_filter($equipment, function ($item) {
            return in_array($item['inventoryId'], ['BodyArmour', 'Gloves', 'Boots', 'Helm']);
        });

        return $filteredArray;
    }

    public function weapon()
    {
        $equipment = $this->equipment();

        $filteredArray = array_filter($equipment, function ($item) {
            return in_array($item['inventoryId'], ['Offhand2', 'Offhand', 'Weapon', 'Weapon2']);
        });

        return $filteredArray;
    }

    public function bijuteri()
    {
        $equipment = $this->equipment();

        $filteredArray = array_filter($equipment, function ($item) {
            return in_array($item['inventoryId'], ['Trinket', 'Belt', 'Ring', 'Ring2', 'Amulet']);
        });

        return $filteredArray;
    }

    public function flasks()
    {
        $equipment = $this->equipment();

        $filteredArray = array_filter($equipment, function ($item) {
            return in_array($item['inventoryId'], ['Flask']);
        });

        return $filteredArray;
    }

    public function gemLinks()
    {
        $equipment = $this->equipment();

        if (!isset($equipment)) {
            return [];
        }

        $links = [];

        // Проходим по экипировке
        foreach ($equipment as $item) {
            if (isset($item['socketedItems']) && is_array($item['socketedItems'])) {

                // Собираем камни умений в массив
                $gems = [];

                foreach ($item['socketedItems'] as $gem) {
                    $gems[] = $gem;
                }

                // Привязываем к идентификатору инвентаря
                $links[$item['inventoryId']] = $gems;
            }
        }

        // Сортируем по количеству камней умений
        uasort($links, function ($a, $b) {
            return count($b) - count($a);
        });

        return $links;
    }

    public function getItemByInventoryId(string $inventoryId)
    {
        $equipment = $this->equipment();

        $filteredArray = array_filter($equipment, function ($item) use ($inventoryId) {
            return isset($item['inventoryId']) && $item['inventoryId'] === $inventoryId;
        });

        return !empty($filteredArray) ? reset($filteredArray) : null;
    }

    public function itemsByLevel()
    {
        $equipment = json_decode($this->equipment, true);
        $jewels = json_decode($this->jewels, true);

        $items = array_merge($equipment ?? [], $jewels ?? []);

        foreach ($this->gemLinks() as $gems) {
            $items = array_merge($items ?? [], $gems ?? []);
        }

        if (empty($items)) {
            return [];
        }

        $itemsByLevel = [];

        foreach ($items as $item) {
            $level = 0; // Уровень по умолчанию, если нет требований по уровню

            // Проверяем требования к предмету
            if (isset($item['requirements']) && is_array($item['requirements'])) {
                // Поиск требования по уровню
                foreach ($item['requirements'] as $requirement) {
                    if (isset($requirement['name']) && $requirement['name'] === 'Level') {
                        // Устанавливаем уровень предмета
                        $level = intval($requirement['values'][0][0]);
                        break;
                    }
                }
            }

            // Инициализируем массив для уровня, если его ещё нет
            if (!isset($itemsByLevel[$level])) {
                $itemsByLevel[$level] = [];
            }

            // Добавляем предмет в массив, сгруппированный по уровню
            $itemsByLevel[$level][] = $item;
        }

        // Сортировка массива по ключам (уровням) от меньшего к большему
        ksort($itemsByLevel);

        return $itemsByLevel;
    }
}
