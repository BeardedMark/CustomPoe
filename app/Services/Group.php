<?php

namespace App\Services;

class Group
{
    public $name;
    public $description;
    public $sections = [];

    public function __construct($name = 'Без группы', $description = '')
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function addSection($section)
    {
        $this->sections[] = $section;
    }

    public function isEmpty()
    {
        return empty($this->sections);
    }

    public function getText()
    {
        $result = '';
        $result .= "\n# Group {$this->name} | {$this->description}";

        foreach ($this->sections as $section) {
            $result .= "\n{$section->getText()}";
        }

        return $result;
    }

    public function getPalette(): array
    {
        $uniqueRules = [];
        $seenCombinations = [];

        foreach ($this->sections as $section) {
            foreach ($section->getPalette() as $rule) {
                $paletteCode = $rule->getPaletteCode();

                if (!in_array($paletteCode, $seenCombinations)) {
                    $uniqueRules[] = $rule;
                    $seenCombinations[] = $paletteCode;
                }
            }
        }

        return $uniqueRules;
    }
}