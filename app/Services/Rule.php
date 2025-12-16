<?php

namespace App\Services;

use stdClass;

class Rule
{
    public $id;
    public $name;
    public $description;
    public $data;
    public $commands = [];
    public $uncownCommands = [];

    public stdClass $booleans;
    public stdClass $arrays;
    public stdClass $styles;

    public function __construct($id, $name = 'Без имени', $description = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->data = new \stdClass();
        $this->booleans = new \stdClass();
        $this->arrays = new \stdClass();
        $this->styles = new \stdClass();
    }

    public function getName()
    {
        $name = $this->name;

        if (empty($name)) {
            $name = $this->getExample();
        }

        return $name ? $name : "Rule";
    }

    public function getDescription()
    {
        $result = $this->description;

        if (empty($result)) {
            if (!empty($this->data->baseTypes)) {
                $result = implode(', ', $this->data->baseTypes);
            }
        }

        return $result;
    }

    public function getExample(): string
    {
        $example = null;

        if (empty($example) && $this->getBaseType()) {
            $example = $this->getRandomItem($this->getBaseType());
        }

        if (empty($example) && $this->getClass()) {
            $example = $this->getRandomItem($this->getClass());
        }

        $example = $example ?? "Item";

        if (!empty($this->getRarity())) {
            $example = "{$this->getRandomItem($this->getRarity())} " . $example;
        }

        if (!empty($this->getLinkedSockets())) {
            $example = "{$this->getLinkedSockets()->value}L " . $example;
        }

        if (!empty($this->getSockets())) {
            $example = "{$this->getSockets()->value}S " . $example;
        }

        if (!empty($this->getHeight())) {
            $example = "{$this->getHeight()->value}h " . $example;
        }

        if (!empty($this->getWidth())) {
            $example = "{$this->getWidth()->value}w " . $example;
        }

        if (!empty($this->getStackSize())) {
            $example = "{$this->getStackSize()->value}x " . $example;
        }

        if (!empty($this->getQuality())) {
            $example = "{$this->getQuality()->value}% " . $example;
        }

        if (!empty($this->getBaseArmour())) {
            $example .= " (Ar {$this->getBaseArmour()->value})";
        }

        if (!empty($this->getBaseEvasion())) {
            $example .= " (Ev {$this->getBaseEvasion()->value})";
        }

        if (!empty($this->getBaseEnergyShield())) {
            $example .= " (Es {$this->getBaseEnergyShield()->value})";
        }

        if (!empty($this->getBaseWard())) {
            $example .= " (Wd {$this->getBaseWard()->value})";
        }

        if (!empty($this->getBaseDefencePercentile())) {
            $example .= " (Dp {$this->getBaseDefencePercentile()->value})";
        }

        if (!empty($this->getMapTier())) {
            $example .= " (Tier {$this->getMapTier()->value})";
        }

        if (!empty($this->getGemLevel())) {
            $example .= " (Glvl {$this->getGemLevel()->value})";
        }

        if (!empty($this->getItemLevel())) {
            $example .= " (Ilvl {$this->getItemLevel()->value})";
        }

        if (!empty($this->getAreaLevel())) {
            $example .= " (Alvl {$this->getAreaLevel()->value})";
        }

        if (!empty($this->getDropLevel())) {
            $example .= " (Dlvl {$this->getDropLevel()->value})";
        }

        return $example;
    }

    public function getText()
    {
        $result = '';

        foreach ($this->commands as $command) {
            $result .= "\n{$command->name} {$command->value} {$command->comment}";
        }

        return $result;
    }

    public function getCode()
    {
        $result = '';

        foreach ($this->commands as $command) {
            $result .= "\n{$command->name} {$command->value}";
        }

        return $result;
    }

    // public function checkBooleans(): bool
    // {
    //     return $this->getAlternateQuality()
    //         || $this->getAnyEnchantment()
    //         || $this->getBlightedMap()
    //         || $this->getCorrupted()
    //         || $this->getElderItem()
    //         || $this->getElderMap()
    //         || $this->getFracturedItem()
    //         || $this->getHasCruciblePassiveTree()
    //         || $this->getHasImplicitMod()
    //         || $this->getIdentified()
    //         || $this->getMirrored()
    //         || $this->getReplica()
    //         || $this->getScourged()
    //         || $this->getShapedMap()
    //         || $this->getShaperItem()
    //         || $this->getSynthesisedItem()
    //         || $this->getTransfiguredGem()
    //         || $this->getUberBlightedMap()
    //         || $this->getVeiledItem();
    // }

    // public function checkArrays()
    // {
    //     return $this->getRarity()
    //         || $this->getClass()
    //         || $this->getBaseType()
    //         || $this->getHasEnchantment()
    //         || $this->getHasExplicitMod()
    //         || $this->getEnchantmentPassiveNode()
    //         || $this->getArchnemesisMod()
    //         || $this->getHasInfluence();
    // }

    // public function checkNumerics(): bool
    // {
    //     return $this->getWidth()
    //         || $this->getHeight()
    //         || $this->getStackSize()
    //         || $this->getEnchantmentPassiveNum()
    //         || $this->getLinkedSockets()
    //         || $this->getSockets()
    //         || $this->getSocketGroup()
    //         || $this->getQuality()
    //         || $this->getItemLevel()
    //         || $this->getAreaLevel()
    //         || $this->getDropLevel()
    //         || $this->getGemLevel()
    //         || $this->getMapTier()

    //         || $this->getBaseArmour()
    //         || $this->getBaseEnergyShield()
    //         || $this->getBaseEvasion()
    //         || $this->getBaseWard()
    //         || $this->getBaseDefencePercentile()

    //         || $this->getCorruptedMods()
    //         || $this->getHasEaterOfWorldsImplicit()
    //         || $this->getHasSearingExarchImplicit();
    // }

    public function getStyles()
    {
        return $this->styles == new \stdClass() ? null : $this->booleans;
    }

    // * Styles

    public function getTextColor()
    {
        $textColor = $this->styles->textColor ?? null;

        if (!isset($textColor)) {
            if (isset($this->arrays->rarity)) {
                foreach ($this->arrays->rarity as $rarity) {
                    if (preg_match('/Normal/i', $rarity)) {
                        $textColor = '#c8c8c8';
                    } elseif (preg_match('/Magic/i', $rarity)) {
                        $textColor = '#8888ff';
                    } elseif (preg_match('/Rare/i', $rarity)) {
                        $textColor = '#ffff77';
                    } elseif (preg_match('/Unique/i', $rarity)) {
                        $textColor = '#af6025';
                    }
                }
            }

            if (isset($this->arrays->classes)) {
                foreach ($this->arrays->classes as $class) {
                    if (preg_match('/Quest\s?(?:item)?/i', $class)) {
                        $textColor = '#4ae63a';
                    } elseif (preg_match('/Gem/i', $class)) {
                        $textColor = '#1ba29b';
                    } elseif (preg_match('/Divination\s?(?:card)/i', $class)) {
                        $textColor = '#0ebaff';
                    } elseif (preg_match('/Currency/i', $class)) {
                        $textColor = '#aa9e82';
                    }
                }
            }
        }

        // return $textColor ?? '#7f7f7f';
        return $textColor ?? '#ffff77';
    }

    // * Counters

    public function getWidth()
    {
        return $this->getNumeric('Width', 1);
    }

    public function getHeight()
    {
        return $this->getNumeric('Height', 1);
    }

    public function getStackSize()
    {
        return $this->getNumeric('StackSize', 1);
    }

    public function getEnchantmentPassiveNum()
    {
        return $this->getNumeric('EnchantmentPassiveNum', 1);
    }

    public function getLinkedSockets()
    {
        return $this->getNumeric('LinkedSockets', 0);
    }

    public function getSockets()
    {
        return $this->getNumeric('Sockets', 0);
    }

    public function getSocketGroup()
    {
        return $this->getNumeric('SocketGroup', 0);
    }

    public function getSocketsColor()
    {
        $sockets = $this->getTargetCommands('Sockets');
        $linkedSockets = $this->getTargetCommands('SocketGroup');

        $commands = array_merge($sockets, $linkedSockets);


        if (empty($commands)) {
            return null;
        }

        $colors = [];

        foreach ($commands as $command) {
            if (preg_match('/([A-Z]+\b)/', $command->value, $matches)) {
                $colors = array_merge($colors, str_split($matches[1]));

                // $colors = array_unique($merged);
            }
        }

        return $colors;
    }

    public function getAllSocketColors()
    {
        $colors = $this->getSocketsColor();

        while (count($colors) < 6) {
            $colors[] = 'W';
        }

        return $colors;
    }


    public function getQuality()
    {
        return $this->getNumeric('Quality', 0);
    }

    // ? Levels

    public function getItemLevel()
    {
        return $this->getNumeric('ItemLevel', 1);
    }

    public function getAreaLevel()
    {
        return $this->getNumeric('AreaLevel', 1);
    }

    public function getDropLevel()
    {
        return $this->getNumeric('DropLevel', 1);
    }

    public function getGemLevel()
    {
        return $this->getNumeric('GemLevel', 1);
    }

    public function getMapTier()
    {
        return $this->getNumeric('MapTier', 1);
    }

    // ? Defends

    public function getBaseArmour()
    {
        return $this->getNumeric('BaseArmour', 0);
    }

    public function getBaseEnergyShield()
    {
        return $this->getNumeric('BaseEnergyShield', 0);
    }

    public function getBaseEvasion()
    {
        return $this->getNumeric('BaseEvasion', 0);
    }

    public function getBaseWard()
    {
        return $this->getNumeric('BaseWard', 0);
    }

    public function getBaseDefencePercentile()
    {
        return $this->getNumeric('BaseDefencePercentile', 0);
    }

    // ? Mods

    public function getCorruptedMods()
    {
        return $this->getNumeric('CorruptedMods', 0);
    }

    public function getHasEaterOfWorldsImplicit()
    {
        return $this->getNumeric('HasEaterOfWorldsImplicit', 0);
    }

    public function getHasSearingExarchImplicit()
    {
        return $this->getNumeric('HasSearingExarchImplicit', 0);
    }

    // * Arrays

    public function getRarity()
    {
        return $this->getArray('Rarity');
    }

    public function getClass()
    {
        return $this->getArray('Class');
    }

    public function getBaseType()
    {
        return $this->getArray('BaseType');
    }

    public function getHasEnchantment()
    {
        return $this->getNumeric('HasEnchantment');
    }

    public function getHasExplicitMod()
    {
        $result = new stdClass;
        $result->numeric = $this->getNumeric('HasExplicitMod');
        $result->array = $this->getArray('HasExplicitMod');
        return $result === new stdClass ? null : $result;
    }

    public function getEnchantmentPassiveNode()
    {
        return $this->getArray('EnchantmentPassiveNode');
    }

    public function getArchnemesisMod()
    {
        return $this->getArray('ArchnemesisMod');
    }

    public function getHasInfluence()
    {
        return $this->getArray('HasInfluence');
    }

    // * Booleans

    public function getAlternateQuality()
    {
        return $this->getBoolean('AlternateQuality');
    }

    public function getAnyEnchantment()
    {
        return $this->getBoolean('AnyEnchantment');
    }

    public function getBlightedMap()
    {
        return $this->getBoolean('BlightedMap');
    }

    public function getCorrupted()
    {
        return $this->getBoolean('Corrupted');
    }

    public function getElderItem()
    {
        return $this->getBoolean('ElderItem');
    }

    public function getElderMap()
    {
        return $this->getBoolean('ElderMap');
    }

    public function getFracturedItem()
    {
        return $this->getBoolean('FracturedItem');
    }

    public function getHasCruciblePassiveTree()
    {
        return $this->getBoolean('HasCruciblePassiveTree');
    }

    public function getHasImplicitMod()
    {
        return $this->getBoolean('HasImplicitMod');
    }

    public function getIdentified()
    {
        return $this->getBoolean('Identified');
    }

    public function getMirrored(): ?bool
    {
        return $this->getBoolean('Mirrored');
    }

    public function getReplica()
    {
        return $this->getBoolean('Replica');
    }

    public function getScourged()
    {
        return $this->getBoolean('Scourged');
    }

    public function getShapedMap()
    {
        return $this->getBoolean('ShapedMap');
    }

    public function getShaperItem()
    {
        return $this->getBoolean('ShaperItem');
    }

    public function getSynthesisedItem()
    {
        return $this->getBoolean('SynthesisedItem');
    }

    public function getTransfiguredGem()
    {
        return $this->getBoolean('TransfiguredGem');
    }

    public function getUberBlightedMap()
    {
        return $this->getBoolean('UberBlightedMap');
    }

    public function getVeiledItem()
    {
        $targets = ['Veil'];
        $array = $this->getHasExplicitMod()->array;

        if (empty($array)) {
            return null;
        }

        return $this->checkAllTargetsInArray($array, $targets);
    }

    public function getQuestItem()
    {
        $array = $this->getClass();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Quest', 'Pantheon', 'Invitation', 'Vessel']);
        }

        return null;
    }

    public function getBreachItem()
    {
        $result = null;
        return $result;

        $classes = $this->getClass();
        if (!empty($classes)) {
            $result = $this->checkAllTargetsInArray($classes, ['Breach', 'Breachstone']);
        }

        $bases = $this->getBaseType();
        if (!empty($bases)) {
            $result = $this->checkAllTargetsInArray($bases, ['Splinter', 'Blessing', 'Breach', 'Breachstone']);
        }

        return $result;
    }

    public function getEssenceItem()
    {
        $targets = ['Remnant', 'Essence'];
        $array = $this->getBaseType();

        if (empty($array)) {
            return null;
        }

        return $this->checkAllTargetsInArray($array, $targets);
    }

    public function getTalismanItem()
    {
        $targets = ['Talisman'];
        $array = $this->getBaseType();

        if (empty($array)) {
            return null;
        }

        return $this->checkAllTargetsInArray($array, $targets);
    }

    public function getMapItem()
    {
        $array = $this->getClass();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Map', 'Pantheon', 'Memories', 'Memory', 'Atlas Upgrade']);
        }

        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Voidstone', 'Invitation', 'Reliquary']);
        }

        if ($this->getUberBlightedMap() !== null || $this->getMapTier() !== null || $this->getBlightedMap() !== null || $this->getElderMap() !== null || $this->getShapedMap() !== null) {
            return true;
        }

        return null;
    }

    public function getAbyssItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Vise']);
        }

        $array = $this->getClass();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Abyss', 'Jewels']);
        }

        return null;
    }

    public function getRitualItem()
    {
        $targets = ['Ritual'];
        $array = $this->getBaseType();

        if (empty($array)) {
            return null;
        }

        return $this->checkAllTargetsInArray($array, $targets);
    }

    public function getHeistItem()
    {
        $array = $this->getClass();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Heist', 'Contract', 'Blueprint', 'Trinket', 'Relic']);
        }

        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ["Rogue's", 'Trinket', 'Contract', 'Blueprint', 'Report']);
        }

        return null;
    }

    public function getDeliriumItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Delirium', 'Simulacrum', 'Cluster']);
        }

        return null;
    }

    public function getIncursionItem()
    {
        $hasExplicitMod = $this->getHasExplicitMod()->array;
        if (!empty($hasExplicitMod)) {
            return $this->checkAllTargetsInArray($hasExplicitMod, ['Citaqualotl', 'Guatelitzi', 'Matatl', 'Puhuarte', 'Tacati', 'Topotante', 'Xopec']);
        }

        $baseType = $this->getBaseType();
        if (!empty($baseType)) {
            return $this->checkAllTargetsInArray($baseType, ['Vial']);
        }

        return null;
    }

    public function getExpeditionItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Expedition', 'Logbook', 'Logbook']);
        }

        return null;
    }

    public function getHarvestItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Lifeforce']);
        }

        return null;
    }

    public function getBlightItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Oil']);
        }

        return null;
    }

    public function getLegionItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Timeless', 'Incubator']);
        }

        return null;
    }

    public function getMetamorphItem()
    {
        $array = $this->getBaseType();
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Catalyst', 'Metamorph']);
        }

        return null;
    }

    public function getDelveItem()
    {
        $classes = $this->getClass();
        if (!empty($classes)) {
            return $this->checkAllTargetsInArray($classes, ['Delve']);
        }

        $bases = $this->getBaseType();
        if (!empty($bases)) {
            return $this->checkAllTargetsInArray($bases, ['Fossil', 'Resonator']);
        }

        $explicids = $this->getHasExplicitMod()->array;
        if (!empty($explicids)) {
            return $this->checkAllTargetsInArray($explicids, ['Underground', 'Subterranean', 'Crafting']);
        }

        return null;
    }

    public function getBestiaryItem()
    {
        $array = $this->getHasExplicitMod()->array;
        if (!empty($array)) {
            return $this->checkAllTargetsInArray($array, ['Farrul', 'Fenumus', 'Craiceann', 'Saqawal']);
        }

        $bases = $this->getBaseType();
        if (!empty($bases)) {
            return $this->checkAllTargetsInArray($bases, ['Net']);
        }

        return null;
    }

    public function getCardItem()
    {
        $class = $this->getClass();
        if (!empty($class)) {
            return $this->checkAllTargetsInArray($class, ['Card']);
        }

        $baseType = $this->getBaseType();
        if (!empty($baseType)) {
            return $this->checkAllTargetsInArray($baseType, ['Deck']);
        }

        return null;
    }

    public function setCommand($name, $value)
    {
        foreach ($this->commands as $command) {
            if ($command->name === $name) {
                $command->value = $value;
                break;
            }
        }
    }

    public function addCommand($command)
    {
        $this->commands[] = $command;

        if (preg_match('/Show\b/i', $command->name)) {
            $this->data->visible = true;
        } elseif (preg_match('/Hide\b/i', $command->name)) {
            $this->data->visible = false;
        }

        // Styles
        elseif (preg_match('/SetFontSize\b/i', $command->name)) {
            $this->styles->fontSize = $command->value;
        } elseif (preg_match('/SetTextColor\b/i', $command->name)) {
            $this->styles->textColor = $this->getColor($command->value);
        } elseif (preg_match('/SetBorderColor\b/i', $command->name)) {
            $this->styles->borderColor = $this->getColor($command->value);
        } elseif (preg_match('/SetBackgroundColor\b/i', $command->name)) {
            $this->styles->backgroundColor = $this->getColor($command->value);
        } elseif (preg_match('/PlayAlertSound/i', $command->name)) {
            $alertSound = new \stdClass();
            if (preg_match('/^\s*(\S*)\s(\d*)/', $command->value, $matches)) {
                $alertSound->sound = $matches[1];
                $alertSound->volume = $matches[2];
            }
            $this->styles->alertSound = $alertSound;
        } elseif (preg_match('/.*MinimapIcon\b/i', $command->name)) {
            $minimapIcon = new \stdClass();
            if (preg_match('/^\s*(\d*)\s?(\w*)\s?(\w*)(?:\s*(#\s*.*\S)\s*$)?/', $command->value, $matches)) {
                $minimapIcon->size = $matches[1];
                $minimapIcon->color = $matches[2];
                $minimapIcon->shape = $matches[3];
            }
            $this->styles->minimapIcon = $minimapIcon;
        } elseif (preg_match('/.*PlayEffect\b/i', $command->name)) {
            $effect = new \stdClass();
            if (preg_match('/^\s*(\w*)\s?(\w*)?(?:\s*(#\s*.*\S)\s*$)?$/', $command->value, $matches)) {
                $effect->color = $matches[1];
                $effect->type = $matches[2] ?? null;
            }
            $this->styles->effect = $effect;
        } else {
            $this->uncownCommands[] = $command;
        }
    }

    public function getTargetCommands(string $name)
    {
        $regex = '/^' . preg_quote($name, '/') . '/i';
        $commands = $this->commands;

        return array_filter($commands, function ($command) use ($regex) {
            return preg_match($regex, $command->name);
        });
    }

    public function getPaletteCode()
    {
        $commands = $this->styles;

        $code = '';
        $code .= $commands->textColor ?? '' . '|';
        $code .= $commands->borderColor ?? '' . '|';
        $code .= $commands->backgroundColor ?? '';

        return $code;
    }

    private function getColor(string $value)
    {
        $color = null;

        if (preg_match('/^\s*(\d+)\s+(\d+)\s+(\d+)\s*(\d+)?(?:\s*(#\s*.*\S)\s*$)?/', $value, $matches)) {
            $color = sprintf("#%02x%02x%02x%02x", $matches[1], $matches[2], $matches[3], $matches[4] ?? 255);
        }

        return $color;
    }

    private function getArray(string $name)
    {
        $commands = $this->getTargetCommands($name);

        if (empty($commands)) {
            return null;
        }

        $array = [];

        foreach ($commands as $command) {
            preg_match_all('/"(\w[^"]+)"/', $command->value, $matches);

            if (count($matches[1]) == 0) {
                preg_match_all('/\b(\w+)\b/', $command->value, $matches);
            }
            $array = array_merge($array, $matches[1]);
        }

        return $array;
    }

    public function checkTargetsInArray(array $array, array $targets): bool
    {
        foreach ($targets as $target) {
            foreach ($array as $item) {
                if (strpos($item, $target) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function checkAllTargetsInArray(array $array, array $targets): bool
    {
        if (empty($array)) {
            return null;
        }
        // Проходим по каждому элементу массива для поиска
        foreach ($array as $item) {
            $found = false;

            // Проверяем, содержится ли хотя бы одна подстрока из targets в текущем элементе
            foreach ($targets as $target) {
                if (strpos($item, $target) !== false) {
                    $found = true;
                    break; // Если найдена хотя бы одна подстрока, выходим из внутреннего цикла
                }
            }

            // Если хотя бы в одном элементе не найдена ни одна подстрока, возвращаем false
            if (!$found) {
                return false;
            }
        }

        // Если все элементы массива содержат хотя бы одну подстроку, возвращаем true
        return true;
    }

    public function getRandomItem(array $array)
    {
        $result = null;

        if (!empty($array)) {
            $randomKey = array_rand($array);
            $result = $array[$randomKey];
        }
        return $result;
    }

    private function getBoolean(string $name): ?bool
    {
        $commands = $this->getTargetCommands($name);
    
        if (empty($commands)) {
            return null;
        }
    
        foreach ($commands as $command) {
            if (preg_match('/false/i', $command->value)) {
                return false;
            } elseif (preg_match('/true/i', $command->value)) {
                return true;
            }
        }
    
        // Если ни одно из условий не подошло, вернем null
        return null;
    }

    private function getNumeric(string $name, ?int $min = null, ?int $max = null): ?object
    {
        $commands = $this->getTargetCommands($name);

        if (empty($commands)) {
            return null;
        }

        $numeric = new \stdClass();
        $numeric->min = $min;
        $numeric->max = $max;

        $numeric->from = null;
        $numeric->to = null;
        $numeric->equals = null;
        $numeric->unequals = null;

        $numeric->value = null;
        $numeric->title = null;

        foreach ($commands as $command) {
            if (preg_match('/(==|>=|<=|>|<|=|!)?\s*(\d+|[A-Z]+)/', $command->value, $matches)) {
                $operator = $matches[1] ?? '';
                $number = is_numeric($matches[2]) ? intval($matches[2]) : strlen($matches[2]);

                switch ($operator) {
                    case '>=':
                        $numeric->from = $numeric->from ? min($numeric->from, $number) : $number;
                        break;
                    case '<=':
                        $numeric->to = $numeric->to ? max($numeric->to ?? $numeric->min, $number) : $number;
                        break;
                    case '>':
                        $numeric->from = $numeric->from ? min($numeric->from, $number + 1) : $number + 1;
                        break;
                    case '<':
                        $numeric->to = $numeric->to ? max($numeric->to ?? $numeric->min, $number - 1) : $number - 1;
                        break;
                    case '=':
                    case '==':
                    case '':
                        $numeric->equals = $number;
                        break;
                    case '!':
                        $numeric->unequals = $number;
                        break;
                }
            }
        }

        $numeric->value = $numeric->equals ?? $numeric->from ?? $numeric->to;

        // Если from и to не изменились, устанавливаем их в default-значения
        $numeric->from = ($numeric->from === $numeric->max) ? $numeric->min : $numeric->from;

        if ($numeric->to === null) {
            if ($numeric->from !== $numeric->min) {
                $numeric->title = "{$numeric->from}+";
            }
        } elseif ($numeric->from !== $numeric->min || $numeric->to !== $numeric->max) {
            $numeric->title = "{$numeric->from}-{$numeric->to}";
        }
        if (empty($numeric->title)) {
            $numeric->title = $numeric->equals ?? $numeric->from ?? $numeric->to;
        }
        // $numeric->title = $numeric->value;

        // Если есть значение equals, то используем его как value, иначе выбираем между from и to
        // $numeric->value = $numeric->equals ? $numeric->equals : max($numeric->to ?? $numeric->min, $numeric->from);

        return $numeric;
    }
}
