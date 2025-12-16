<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use App\Services\ItemFilter;
use App\Services\Parser;
use Carbon\Carbon;
use stdClass;

class Filter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'realm',
        'description',
        'version',
        'type',
        'is_public',
        'before',
        'content',
        'after',
        'comment',
        'user_id',
        'filter',
        'icon',
        'wallpaper',
        'gallery',
        'link',
        'webhook',
        'downloads',
        'views',
    ];

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

    public static function realms()
    {
        return ['PC', 'SONY', 'XBOX'];
    }

    public static function types()
    {
        return ['Normal', 'Ruthless'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gallery()
    {
        return explode("\n", $this->gallery);;
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

    // * Лютый кастом

    public function setSettings($settings)
    {
        $jsonSettings = json_encode($settings);
        session([$this->id => $jsonSettings]);

        return $jsonSettings;
    }

    public function getSettings()
    {
        $settings = "";

        if (session($this->id)) {
            $settings = session($this->id);
        }

        $settings = json_decode($settings);

        return $settings;
    }

    // * Формирование файла

    public function text()
    {
        $filter = "# Название : {$this->name}\n";
        $filter .= "# Автор : {$this->user->name}\n";
        $filter .= "# Описание : {$this->description}\n";
        $filter .= "# Версия : {$this->version}\n";
        $filter .= "# Создан : {$this->created_at}\n";
        $filter .= "# Обновлен : {$this->updated_at}\n";

        $sections = $this->applySections();
        $fileContent = implode("\n\n", $sections);
        $filter .= "\n{$fileContent}";

        return $filter;
    }

    public function applySections()
    {
        $settings = $this->getSettings();

        // $itemFilter = new ItemFilter($this->filter);
        // $sections = $itemFilter->getSections();

        $parser = new Parser();
        $lines = explode("\n", $this->filter);
        $parser->parse($lines);
        $parser->removeEmptySectionsAndGroups();
        $sections = $parser->getSections();

        $resultFilter = [];

        foreach ($sections as $section) {
            if (!isset($settings->{'sections'}->{'S' . $section->id})) {
                if (isset($settings->{'global'})) {
                    $sectionsForFile = [];

                    foreach ($section->rules as $rule) {
                        if (!isset($settings->{'rules'}->{$section->id}->{$rule->id})) {
                            $rule->commands = $this->applyGlobal($rule->commands);
                            $sectionsForFile[] = $rule->getText();
                        }
                    }

                    $resultFilter[] = implode("\n", $sectionsForFile);
                } else {
                    $sectionsForFile = [];

                    foreach ($section->rules as $rule) {
                        if (!isset($settings->{'rules'}->{'S' . $section->id}->{'R' . $rule->id})) {
                            $sectionsForFile[] = $rule->getText();
                        }
                    }

                    $resultFilter[] = implode("\n", $sectionsForFile);
                }
            }
        }

        return $resultFilter;
    }

    public function applyGlobal($lines)
    {
        if (!$this->getSettings()) {
            return null;
        }

        $settings = $this->getSettings()->{'global'};

        switch ($settings->{'size'}) {
            default:
                $size = $settings->{'size'};
                if ($size != 0) {
                    $lines = array_map(function ($line) use ($size) {
                        if (strpos($line->name, 'SetFontSize') !== false) {
                            // $str = trim($line);
                            // $parts = explode(' ', $str);
                            // $currentFontSize = (float)$parts[1];
                            $currentFontSize = $line->value;
                            $newFontSize = $currentFontSize + ($currentFontSize * ($size / 100));
                            $line->value = max(11, min(45, round($newFontSize)));
                        }
                        return $line;
                    }, $lines);
                }

                break;
        }

        // Обработка настройки "transparent"
        switch ($settings->{'transparent'} ?? null) {
            case 'off':
                $lines = array_map(function ($line) {
                    if (strpos($line->name, 'Color') !== false) {
                        $parts = explode(' ', trim($line->value));
                        unset($parts[3]);
                        $line->value = implode(' ', $parts);
                    }
                    return $line;
                }, $lines);
                break;
        }

        // Обработка настройки "customSounds"
        switch ($settings->{'customSounds'} ?? null) {
            case 'off':

                $lines = array_map(function ($line) {
                    if (strpos($line->name, 'CustomAlertSound') !== false) {
                        $line->value = "1 150";
                    }
                    return $line;
                }, $lines);
                break;
        }

        // Обработка настройки "setVolume"
        switch ($settings->{'setVolume'} ?? null) {
            case 'on':
                $soundSubstrings = ['PlayAlertSound', 'PlayAlertSoundPositional'];
                $lines = array_map(function ($line) use ($soundSubstrings) {
                    foreach ($soundSubstrings as $soundSubstring) {
                        if (strpos($line->name, $soundSubstring) !== false) {
                            $str = trim($line->value);
                            $parts = explode(' ', $str);
                            $parts[1] = 150;
                            $line->value = implode(' ', $parts);
                        }
                        return $line;
                    }
                }, $lines);
                break;
        }

        // Обработка настройки "posSound"
        switch ($settings->{'posSound'} ?? null) {
            case 'off':
                $lines = array_map(function ($line) {
                    $line->name = str_replace("PlayAlertSoundPositional", "PlayAlertSound", $line->name);
                    return $line;
                }, $lines);
                break;
        }

        // Обработка настройки "volume"
        switch ($settings->{'volume'} ?? null) {
            default:
                $volume = $settings->{'volume'};
                $soundSubstrings = ['PlayAlertSound', 'PlayAlertSoundPositional'];

                if ($volume != 0) {
                    $lines = array_map(function ($line) use ($volume, $soundSubstrings) {
                        foreach ($soundSubstrings as $soundSubstring) {
                            if (strpos($line->name, $soundSubstring) !== false) {
                                $str = trim($line->value);
                                $parts = explode(' ', $str);
                                $currentVolume = (float)$parts[1];
                                $newVolume = $currentVolume + ($currentVolume * ($volume / 100));
                                $parts[1] = max(0, min(300, round($newVolume)));
                                $line->value = implode(' ', $parts);
                            } else {
                                return $line;
                            }
                        }
                    }, $lines);
                }
                break;
        }

        // // Обработка настройки "defSound"
        // switch ($settings->{'defSound'} ?? null) {
        //     case 'off':
        //         $lines[] = "DisableDropSound";
        //         break;
        // }

        // Обработка настройки "icon"
        switch ($settings->{'icons'} ?? null) {
            case 'off':
                $lines = array_filter($lines, function ($line) {
                    return strpos($line->name, 'MinimapIcon') === false;
                });
                break;
        }

        // Обработка настройки "ray"
        switch ($settings->{'rays'} ?? null) {
            case 'off':
                $lines = array_filter($lines, function ($line) {
                    return strpos($line->name, 'PlayEffect') === false;
                });
                break;
        }

        // // Обработка настройки "trash"
        // switch ($settings->{'trash'} ?? null) {
        //     case 'off':
        //         $lines[] = "Hide";
        //         $lines[] = "Width >= 1";
        //         $lines[] = "SetFontSize = 11";
        //         $lines[] = "SetTextColor = 0 0 0 0";
        //         $lines[] = "SetBorderColor = 0 0 0 0";
        //         $lines[] = "SetBackgroundColor = 0 0 0 0";
        //         $lines[] = "DisableDropSound";
        //         break;
        // }

        return $lines;
    }

    // * Работа со структурой

    // public function getLines(): array
    // {
    //     $text = $this->filter;
    //     $lines = explode(PHP_EOL, $text);  // Разделяем текст на строки
    //     $cleanedLines = [];

    //     foreach ($lines as $line) {
    //         $line = trim(preg_replace('/\s+/', ' ', $line));  // Удаляем лишние пробелы и табуляции
    //         if (!empty($line)) {
    //             $cleanedLines[] = $line;  // Убираем пустые строки
    //         }
    //     }

    //     return $cleanedLines;
    // }

    // public function getSections(array $lines): array
    // {
    //     $sections = [];
    //     $currentSection = [];
    //     $group = null;

    //     for ($i = 0; $i < count($lines); $i++) {
    //         $line = $lines[$i];
    //         if (preg_match('/^#\s*\[\[.*\]\]\s?(.*)$/', $line, $matches)) {
    //             $group = $matches[1];
    //         }
    //         if (
    //             preg_match('/^#\s?[Ss]ection:?\s?(.*?)(?:\s?\|\s?(.*))?$/', $line, $matches) ||
    //             (preg_match('/^#\s*\[.*\]\s?(.*)$/', $line, $matches))
    //         ) {
    //             if (!empty($currentSection['rules'])) {
    //                 $sections[] = $currentSection;
    //             }

    //             $currentSection = [
    //                 'id' => $i,
    //                 'name' => $matches[1] ?? null,
    //                 'description' => $matches[2] ?? null,
    //                 'group' => $group,
    //             ];
    //         }

    //         if (preg_match('/^#name\s+(.*)$/', $line, $matches)) {
    //             $currentSection['name'] = $matches[1];
    //         }
    //         if (preg_match('/^#description\s+(.*)$/', $line, $matches)) {
    //             $currentSection['description'] = $matches[1];
    //         }
    //         if (preg_match('/^#group\s+(.*)$/', $line, $matches)) {
    //             $currentSection['group'] = $matches[1];
    //         }
    //         $currentSection['rules'][] = $line;
    //     }

    //     if (!empty($currentSection['rules'])) {
    //         $sections[] = $currentSection;
    //     }

    //     return $sections;
    // }

    // public function getRules(array $lines): array
    // {
    //     $rules = [];
    //     $currentRule = [];
    //     $isCollecting = false; // Флаг для отслеживания начала сбора правил

    //     foreach ($lines as $line) {
    //         // Проверяем, соответствует ли строка регулярному выражению для правил
    //         if (preg_match('/^(?:#\s?)?(?:[Ss]how|[Hh]ide).?#?.?(.*?)(?:\s?\|\s?(.*))?$/', $line, $matches)) {
    //             if (!empty($currentRule['data'])) {
    //                 $rules[] = $currentRule;
    //             }

    //             $currentRule = [
    //                 'name' => trim($matches[1] ?? null),
    //                 'description' => trim($matches[2] ?? null),
    //                 'data' => []
    //             ];
    //             $isCollecting = true;
    //         }

    //         if (preg_match('/^#name\s+(.*)$/', $line, $matches)) {
    //             $currentRule['name'] = $matches[1];
    //         } elseif (preg_match('/^#description\s+(.*)$/', $line, $matches)) {
    //             $currentRule['description'] = $matches[1];
    //         } elseif (preg_match('/^SetTextColor\s+(\d+)\s(\d+)\s(\d+)\s?(\d+)?$/', $line, $matches)) {
    //             $currentRule['textColor'] = sprintf("#%02x%02x%02x%02x", $matches[1], $matches[2], $matches[3], $matches[4] ?? 255);
    //         } elseif (preg_match('/^SetBackgroundColor\s+(\d+)\s(\d+)\s(\d+)\s?(\d+)?$/', $line, $matches)) {
    //             $currentRule['backgroundColor'] = sprintf("#%02x%02x%02x%02x", $matches[1], $matches[2], $matches[3], $matches[4] ?? 255);
    //         } elseif (preg_match('/^SetBorderColor\s+(\d+)\s(\d+)\s(\d+)\s?(\d+)?$/', $line, $matches)) {
    //             $currentRule['borderColor'] = sprintf("#%02x%02x%02x%02x", $matches[1], $matches[2], $matches[3], $matches[4] ?? 255);
    //         } elseif (preg_match('/^SetFontSize\s+(\d{2})$/', $line, $matches)) {
    //             $currentRule['fontSize'] = $matches[1];
    //         } elseif (preg_match('/^PlayEffect\s(.*)\s?(\b.*)$/', $line, $matches)) {
    //             $currentRule['playEffect']['color'] = $matches[1];
    //             $currentRule['playEffect']['type'] = $matches[2] ?? null;
    //         } elseif (preg_match('/^PlayAlertSound.*\s?\b(\d+)\s+(\d+)\b$/', $line, $matches)) {
    //             $currentRule['sound'] = $matches[1];
    //         }

    //         if ($isCollecting) {
    //             $currentRule['data'][] = $line;
    //         }
    //     }

    //     // Добавляем последний блок правил, если он не пустой
    //     if (!empty($currentRule)) {
    //         $rules[] = $currentRule;
    //     }

    //     return $rules;
    // }
    // public function getUniqueRules(array $rules): array
    // {
    //     usort($rules, function ($a, $b) {
    //         $result = 0;

    //         if ($result === 0) {
    //             $backgroundColorA = isset($a['backgroundColor']) ? $a['backgroundColor'] : '';
    //             $backgroundColorB = isset($b['backgroundColor']) ? $b['backgroundColor'] : '';
    //             $result = ($backgroundColorA <=> $backgroundColorB) * -1;
    //         }

    //         if ($result === 0) {
    //             $borderColorA = isset($a['borderColor']) ? $a['borderColor'] : '';
    //             $borderColorB = isset($b['borderColor']) ? $b['borderColor'] : '';
    //             $result = ($borderColorA <=> $borderColorB) * -1;
    //         }

    //         if ($result === 0) {
    //             $textColorA = isset($a['textColor']) ? $a['textColor'] : '';
    //             $textColorB = isset($b['textColor']) ? $b['textColor'] : '';
    //             $result = ($textColorA <=> $textColorB) * -1;
    //         }

    //         return $result;
    //     });

    //     $uniqueArray = [];
    //     $seenCombinations = [];

    //     foreach ($rules as $rule) {
    //         $combination = "";
    //         $combination .= $rule['textColor'] ?? '';
    //         $combination .= $rule['borderColor'] ?? '';
    //         $combination .= $rule['backgroundColor'] ?? '';
    //         $combination .= $rule['playEffect']['color'] ?? '';
    //         if ($combination && !in_array($combination, $seenCombinations)) {
    //             $uniqueArray[] = $rule;
    //             $seenCombinations[] = $combination;
    //         }
    //     }

    //     return $uniqueArray;
    // }

    // public function getGroups()
    // {
    //     $sections = $this->getStructure();
    //     $groups = [];

    //     foreach ($sections as $section) {
    //         $groupName = $section['group'] ?? null;

    //         if (!isset($groups[$groupName])) {
    //             $groups[$groupName] = [
    //                 'name' => $groupName,
    //                 'sections' => []
    //             ];
    //         }

    //         $groups[$groupName]['sections'][] = $section;
    //     }

    //     usort($groups, function ($a, $b) {
    //         return strcmp($a['name'], $b['name']);
    //     });

    //     return $groups;
    // }

    // public function getStructure(): array
    // {
    //     $structure = [];

    //     $lines = $this->getLines();
    //     $sections = $this->getSections($lines);

    //     foreach ($sections as $section) {
    //         $data = $this->getRules($section['rules']);
    //         $section['rules'] = $data;

    //         if (!empty($section['rules'])) {
    //             $structure[] = $section;
    //         }
    //     }

    //     return $structure;
    // }
}
