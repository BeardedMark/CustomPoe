<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use stdClass;

class Hideout extends Model
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
        'icon',
        'wallpaper',
        'gallery',
        'webhook',
        'link',
        'downloads',
        'views',
        'text',
    ];

    public function getLanguage()
    {
        // Используем регулярное выражение для извлечения значения Hideout Name
        if (preg_match('/Language\s*=\s*"([^"]+)"/', $this->text, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getBase()
    {
        // Используем регулярное выражение для извлечения значения Hideout Name
        if (preg_match('/Hideout Name\s*=\s*"([^"]+)"/', $this->text, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getHash()
    {
        // Используем регулярное выражение для извлечения значения Hideout Name
        if (preg_match('/Hideout Hash\s*=\s*(\d+)/', $this->text, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getDoodads()
    {
        $doodads = [];
        // Используем регулярное выражение для извлечения всех объектов
        if (preg_match_all('/(.*\w+)\s*=\s*\{([^}]+)\}/', $this->text, $matches)) {

            $doodads = $matches[1];
        }
        return $doodads;
    }

    public static function getSearch(array $params)
    {
        $query = self::query();

        if (isset($params['autor'])) {
            $query->where('user_id', 'like', $params['autor']);
        }

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
            return "{$diffInDays} дней назад";
        } elseif ($diffInDays > 7) {
            return "Больше недели";
        } elseif ($diffInDays > 30) {
            return "Больше месяца";
        } elseif ($diffInDays > 365) {
            return "Больше года";
        }
        return $diffInDays;
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

    public function incrementDownloads()
    {
        $this->timestamps = false;
        $this->increment('downloads');
        $this->timestamps = true;
    }

    public function incrementViews()
    {
        $this->timestamps = false;
        $this->increment('views');
        $this->timestamps = true;
    }

    public function getAllUniqueHash()
    {
        preg_match_all('/Hash=(\d+)/', $this->text, $matches);

        // ? $uniqueHashes = array_unique($matches[1]);
        $uniqueHashes = array_count_values($matches[1]);

        return $uniqueHashes;
    }

    public function getDoodadsItem()
    {
        $baseItemTypes = json_decode(File::get(storage_path('app/data/poe/cdn/baseitemtypes.json')), true);
        $hideoutDoodads = json_decode(File::get(storage_path('app/data/poe/cdn/hideoutdoodads.json')), true);
        $hideoutDoodadsTags = json_decode(File::get(storage_path('app/data/poe/cdn/hideoutdoodadtags.json')), true);
        $hideoutDoodadsCategory = json_decode(File::get(storage_path('app/data/poe/cdn/hideoutdoodadcategory.json')), true);

        $doodads = [];
        $hashs = $this->getAllUniqueHash();

        foreach ($hashs as $hash => $count) {
            $item = [];
            $baseItem = collect($baseItemTypes)->firstWhere('HASH32', $hash);
    
            if (!$baseItem) {
                return response()->json(['error' => $hash . ' not found']);
            }
            $item['name'] = $baseItem['Name'];
    
            $doodad = collect($hideoutDoodads)->firstWhere('BaseItemTypesKey', $baseItem['_rid']);
    
            if (!$doodad) {
                return response()->json(['error' => $baseItem['Name'] . ' not found']);
            }

            $category = collect($hideoutDoodadsCategory)->firstWhere('_rid', $doodad['Category']);
            
            if ($category) {
                $item['category'] = $category['Name'];
            }

            $tags = [];
            foreach ($doodad['Tags'] as $tagId) {
                $tag = collect($hideoutDoodadsTags)->firstWhere('_rid', $tagId);
                if ($tag) {
                    $tags[] = $tag['Name'];
                }
            }
            $item['tags'] = $tags;

            $item['mtx'] = false;
            if (in_array(0, $doodad['Tags'])) {
                $item['mtx'] = true;
            }

            $item['count'] = $count;
    
            $doodads[] = $item;
        }

        return $doodads;
    }
    public function getIsMtx()
    {
        $filtered = array_filter($this->getDoodadsItem(), function($item) {
            return isset($item['mtx']) && $item['mtx'] === true;
        });

        if (!empty($filtered)) {
            return true;
        } else {
            return false;
        }
    }
}
