<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use stdClass;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'is_public',
        'data',

        'type',
        'price',
        'currency',
        'count',

        'content',
        'comment',
        'icon',
        'wallpaper',
        'gallery',
        'webhook',
        'link',
        'completed',
        'views',
        'whisps',

        'user_id',
    ];

    public static function types()
    {
        return [
            'Валюта',
            'Предмет',
            'Сборка',

            'Крафт',
            'Прайсчек',
            'Прокачка',
            'Прохождение',
            'Испытания',
            
            'Акты',
            'Боссы',
            'Эндгейм',
            'Лабиринт',
            'Уберконтент',
        ];
    }

    public static function currencies()
    {
        return [
            'Divine',
            'Exaltet',
            'Chaos',
            'Alchemy',
            'Alteration',
        ];
    }

    public static function getSearch(array $params)
    {
        $query = self::query();

        if (isset($params['autor'])) {
            $query->where('user_id', 'like', $params['autor']);
        }
        
        if (isset($params['type'])) {
            $query->where('type', 'like', $params['type']);
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

    public function incrementWhisps()
    {
        $this->timestamps = false;
        $this->increment('whisps');
        $this->timestamps = true;
    }

    public function incrementViews()
    {
        $this->timestamps = false;
        $this->increment('views');
        $this->timestamps = true;
    }

    public function gallery()
    {
        return explode("\n", $this->gallery);
    }
    
    public function getMessageText()
    {
        $character = json_decode($this->user->character, true);
        return '@' . "{$character['name']} Привет! Я хочу " . ($this->is_buying ? 'предложить' : 'приобрести') . " за {$this->price} {$this->currency} : {$this->count} {$this->name}";
    }
}
