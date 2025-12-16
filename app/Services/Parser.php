<?php

namespace App\Services;

class Parser
{
    private $groups = [];
    private $currentGroup;
    private $currentSection;

    public function __construct()
    {
        // Инициализируем первую "нулевую" группу и секцию
        $this->currentGroup = new Group();
        $this->currentSection = new Section(0);
        $this->currentGroup->addSection($this->currentSection);
        $this->groups[] = $this->currentGroup;
    }

    public function parse($lines)
    {
        foreach ($lines as $key => $line) {
            $line = trim($line);

            // Если это группа
            if (
                preg_match('/^#\s*\[\[.*\]\]\s?(.*)$/', $line, $matches) ||
                preg_match('/^#\s?group:?\s?(.*?)(?:\s?\|\s?(.*))?$/i', $line, $matches)
            ) {
                $this->currentGroup = new Group($matches[1], $matches[2] ?? null);
                $this->groups[] = $this->currentGroup;

                // Создаем новую секцию по умолчанию для этой группы
                $this->currentSection = new Section($key);
                $this->currentGroup->addSection($this->currentSection);
            }

            // Если это секция
            elseif (
                preg_match('/^#\s*\[[^\[].*\]\s?(.*)$/', $line, $matches) ||
                preg_match('/^#\s?section:?\s?(.*?)(?:\s?\|\s?(.*))?$/i', $line, $matches)
            ) {
                $this->currentSection = new Section($key, $matches[1], $matches[2] ?? null);
                $this->currentGroup->addSection($this->currentSection);
            }

            // Если это правило Show или Hide
            elseif (preg_match('/^\s?(show|hide).?#?.?(.*?)(?:\s?\|\\s?(.*))?$/i', $line, $matches)) {
                $rule = new Rule($key, $matches[2], $matches[3] ?? null);
                $command = new Command($matches[1]);  // Создаем команду для правила (Show или Hide)
                $rule->addCommand($command);
                $this->currentSection->addRule($rule);
            }

            // Если это команда внутри правила
            elseif (preg_match('/^\s*?(\w+)\s*(.*?)\s*(#.*)?$/i', $line, $matches)) {
                if (!empty($this->currentSection->rules)) {
                    $lastRule = end($this->currentSection->rules);
                    $command = new Command($matches[1], $matches[2] ?? '', $matches[3] ?? '');
                    $lastRule->addCommand($command);
                }
            }
        }
    }

    // Метод для удаления пустых секций и групп
    public function removeEmptySectionsAndGroups()
    {
        foreach ($this->groups as $groupKey => $group) {
            foreach ($group->sections as $sectionKey => $section) {
                if ($section->isEmpty()) {
                    unset($group->sections[$sectionKey]);
                }
            }

            // Если после удаления пустых секций группа осталась пустой, удаляем её
            if ($group->isEmpty()) {
                unset($this->groups[$groupKey]);
            }
        }

        // Сбрасываем ключи массивов, чтобы не было пропусков
        $this->groups = array_values($this->groups);
        foreach ($this->groups as $group) {
            $group->sections = array_values($group->sections);
        }
    }

    // Метод для получения всех групп (если нужен для проверки)
    public function getGroups()
    {
        return $this->groups;
    }

    // Метод для получения списка всех секций
    public function getSections()
    {
        $sections = [];
        foreach ($this->groups as $group) {
            foreach ($group->sections as $section) {
                $sections[] = $section;
            }
        }
        return $sections;
    }

    // Метод для получения списка всех правил
    public function getRules()
    {
        $rules = [];
        foreach ($this->groups as $group) {
            foreach ($group->sections as $section) {
                foreach ($section->rules as $rule) {
                    $rules[] = $rule;
                }
            }
        }
        return $rules;
    }

    // Метод для получения палитры уникальных правил из всех групп
    public function getPalette(): array
    {
        $uniqueRules = [];
        $seenCombinations = [];

        foreach ($this->getRules() as $rule) {
            $paletteCode = $rule->getPaletteCode();

            if (!in_array($paletteCode, $seenCombinations)) {
                $uniqueRules[] = $rule;
                $seenCombinations[] = $paletteCode;
            }
        }

        return $uniqueRules;
    }
    
    public function getUniqueCommandNames(): array
    {
        $uniqueNames = [];
    
        foreach ($this->getRules() as $rule) {
            // Проверяем, есть ли у правила неизвестные команды
            if (isset($rule->uncownCommands)) {
                foreach ($rule->uncownCommands as $command) {
                    // Добавляем имя команды в массив уникальных, если его там еще нет
                    if (!in_array($command->name, $uniqueNames)) {
                        $uniqueNames[] = $command->name;
                    }
                }
            }
        }
    
        return $uniqueNames;
    }
}
