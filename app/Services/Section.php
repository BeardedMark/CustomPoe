<?php

namespace App\Services;

class Section
{
    public $id;
    public $name;
    public $description;
    public $rules = [];

    public function __construct($id, $name = 'Без секции', $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function addRule($rule)
    {
        $this->rules[] = $rule;
    }

    public function isEmpty()
    {
        return empty($this->rules);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getText()
    {
        $result = '';
        $result .= "\n# Section {$this->name} | {$this->description}";

        foreach ($this->rules as $rule) {
            $result .= "\n{$rule->getText()}";
        }

        return $result;
    }

    public function getPalette()
    {
        $uniqueRules = [];
        $seenCombinations = [];

        foreach ($this->rules as $rule) {
            $paletteCode = $rule->getPaletteCode();

            if (!in_array($paletteCode, $seenCombinations)) {
                $uniqueRules[] = $rule;
                $seenCombinations[] = $paletteCode;
            }
        }

        return $uniqueRules;
    }

    public function getCommands()
    {
        if (empty($this->rules)) {
            return [];
        }

        // Начнем с команд первого правила
        $commands = $this->rules[0]->commands;

        foreach ($this->rules as $rule) {
            $commands = array_uintersect(
                $commands,
                $rule->commands,
                function ($a, $b) {
                    // Сравниваем и name, и value
                    $nameComparison = strcmp($a->name, $b->name);
                    if ($nameComparison === 0) {
                        return strcmp($a->value, $b->value);
                    }
                    return $nameComparison;
                }
            );
        }

        return $commands;
    }

    public function getCode()
    {
        $result = "";

        $commonCommands = $this->getCommands();

        if (!empty($commonCommands)) {
            foreach ($commonCommands as $command) {
                $result .= "\n{$command->name} {$command->value}";
            }
        }

        return $result;
    }
}
