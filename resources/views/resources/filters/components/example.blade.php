<div class="flex-row-8 flex-ai-center">


    <div class="flex-row-8 font-color-second pad-x-8 pad-y-2 font-center flex-center example
@if (isset($rule->styles->minimapIcon)) poe-icon poe-icon-{{ $rule->styles->minimapIcon->shape }}-{{ $rule->styles->minimapIcon->color }} @endif
"
        style="color: {{ $rule->styles->textColor ?? 'linear-gradient(to right, #c8c8c8, #8888ff, #ffff77, #af6025);' }};
    background-color: {{ $rule->styles->backgroundColor ?? '#000000cc' }};
    border: solid 1px {{ $rule->styles->borderColor ?? 'transparent' }};
    font-size: {{ isset($rule->styles->fontSize) ? 12 + (24 - 12) * (($rule->styles->fontSize - 11) / (45 - 11)) : '16' }}px; 
    box-shadow: 0px 0px 13px {{ isset($rule->styles->effect) ? $rule->styles->effect->color : 'transparent' }};
    min-inline-size: max-content;">

        @if ($rule->getHasInfluence())
            @foreach ($rule->getHasInfluence() as $infuence)
                <img class="img-contain" src="{{ asset('img/influences/' . $infuence . '.webp') }}">
            @endforeach
        @endif

        @if ($rule->getVeiledItem())
            <img class="img-contain" src="{{ asset('img/influences/Veiled.webp') }}">
        @endif

        @if ($rule->getShaperItem() || $rule->getShapedMap())
            <img class="img-contain" src="{{ asset('img/influences/Shaper.webp') }}">
        @endif

        @if ($rule->getElderItem() || $rule->getElderMap())
            <img class="img-contain" src="{{ asset('img/influences/Elder.webp') }}">
        @endif

        @if ($rule->getReplica() !== null)
            <span class="{{ $rule->getReplica() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Replica.webp') }}">
            </span>
        @endif

        @if ($rule->getFracturedItem() !== null)
            <span class="{{ $rule->getFracturedItem() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Fractured.webp') }}">
            </span>
        @endif

        @if ($rule->getSynthesisedItem() !== null)
            <span class="{{ $rule->getSynthesisedItem() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Synthesised.webp') }}">
            </span>
        @endif

        @if ($rule->getBlightedMap() !== null)
            <span class="{{ $rule->getBlightedMap() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Blighted.png') }}">
            </span>
        @endif

        @if ($rule->getUberBlightedMap() !== null)
            <span class="{{ $rule->getUberBlightedMap() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Blighted.png') }}">
            </span>
        @endif

        <span
            style="
background: {{ $rule->getTextColor() ?? 'linear-gradient(to right, #c8c8c8, #8888ff, #ffff77, #af6025)' }};
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
background-clip: text;
text-fill-color: transparent;">{{ isset($rule->styles->stack) ? $rule->styles->stack->value : '' }}
            {{ $rule->getExample() }}
        </span>

        @if ($rule->getSockets() || $rule->getLinkedSockets() || $rule->getSocketGroup())
            <svg width="11" height="18">
                <!-- Линии соединений -->
                @if ($rule->getLinkedSockets() || $rule->getSocketGroup())
                    @if (
                        ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 1) ||
                            ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 1))
                        <rect x="1" y="1" width="9" height="2" fill="rgb(195, 195, 195)"></rect>
                    @endif
                    @if (
                        ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 2) ||
                            ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 2))
                        <rect x="8" y="1" width="2" height="9" fill="rgb(195, 195, 195)"></rect>
                    @endif
                    @if (
                        ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 3) ||
                            ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 3))
                        <rect x="1" y="8" width="9" height="2" fill="rgb(195, 195, 195)"></rect>
                    @endif
                    @if (
                        ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 4) ||
                            ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 4))
                        <rect x="1" y="8" width="2" height="9" fill="rgb(195, 195, 195)"></rect>
                    @endif
                    @if (
                        ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 5) ||
                            ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 5))
                        <rect x="1" y="15" width="9" height="2" fill="rgb(195, 195, 195)"></rect>
                    @endif
                @endif

                <!-- Сокеты -->
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 0) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 1) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 0))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[0]) ? $rule->getSocketsColor()[0] : 'С' }}"
                        x="0" y="0" width="4" height="4"></rect>
                @endif
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 1) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 2) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 1))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[1]) ? $rule->getSocketsColor()[1] : 'С' }}"
                        x="7" y="0" width="4" height="4"></rect>
                @endif
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 2) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 3) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 2))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[2]) ? $rule->getSocketsColor()[2] : 'С' }}"
                        x="7" y="7" width="4" height="4"></rect>
                @endif
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 3) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 4) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 3))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[3]) ? $rule->getSocketsColor()[3] : 'С' }}"
                        x="0" y="7" width="4" height="4"></rect>
                @endif
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 4) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 5) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 4))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[4]) ? $rule->getSocketsColor()[4] : 'С' }}"
                        x="0" y="14" width="4" height="4"></rect>
                @endif
                @if (
                    ($rule->getLinkedSockets() && $rule->getLinkedSockets()->value > 5) ||
                        ($rule->getSockets() && $rule->getSockets()->value >= 6) ||
                        ($rule->getSocketGroup() && $rule->getSocketGroup()->value > 5))
                    <rect
                        class="decor-socket-{{ isset($rule->getSocketsColor()[5]) ? $rule->getSocketsColor()[5] : 'С' }}"
                        x="7" y="14" width="4" height="4"></rect>
                @endif
            </svg>

        @endif

        @if ($rule->getIncursionItem())
            <img class="img-contain" src="{{ asset('img/influences/Incursion.png') }}">
        @endif

        @if ($rule->getArchnemesisMod())
            <img class="img-contain" src="{{ asset('img/influences/Archnemesis.png') }}">
        @endif

        @if ($rule->getDelveItem())
            <img class="img-contain" src="{{ asset('img/influences/Delve.png') }}">
        @endif

        @if ($rule->getBestiaryItem())
            <img class="img-contain" src="{{ asset('img/influences/Bestiary.png') }}">
        @endif

        @if ($rule->getAbyssItem())
            <img class="img-contain" src="{{ asset('img/influences/Abyss.png') }}">
        @endif

        @if ($rule->getHasCruciblePassiveTree())
            <img class="img-contain" src="{{ asset('img/influences/Crucible.png') }}">
        @endif

        @if ($rule->getRitualItem())
            <img class="img-contain" src="{{ asset('img/influences/Ritual.png') }}">
        @endif

        @if ($rule->getTalismanItem())
            <img class="img-contain" src="{{ asset('img/influences/Talisman.png') }}">
        @endif

        @if ($rule->getHarvestItem())
            <img class="img-contain" src="{{ asset('img/influences/Harvest.png') }}">
        @endif

        @if ($rule->getExpeditionItem())
            <img class="img-contain" src="{{ asset('img/influences/Expedition.png') }}">
        @endif

        @if ($rule->getLegionItem())
            <img class="img-contain" src="{{ asset('img/influences/Legion.png') }}">
        @endif

        @if ($rule->getMetamorphItem())
            <img class="img-contain" src="{{ asset('img/influences/Metamorph.png') }}">
        @endif

        @if ($rule->getQuestItem())
            <img class="img-contain" src="{{ asset('img/influences/Quest.png') }}">
        @endif

        @if ($rule->getCardItem())
            <img class="img-contain" src="{{ asset('img/influences/Card.png') }}">
        @endif

        @if ($rule->getEssenceItem())
            <img class="img-contain" src="{{ asset('img/influences/Essence.png') }}">
        @endif

        @if ($rule->getBlightItem())
            <img class="img-contain" src="{{ asset('img/influences/Blighted.webp') }}">
        @endif

        @if ($rule->getBreachItem())
            <img class="img-contain" src="{{ asset('img/influences/Breach.png') }}">
        @endif

        @if ($rule->getHeistItem())
            <img class="img-contain" src="{{ asset('img/influences/Heist.png') }}">
        @endif

        @if ($rule->getHasImplicitMod() !== null)
            <span class="{{ $rule->getHasImplicitMod() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Implicit.png') }}">
            </span>
        @endif

        @if ($rule->getScourged() !== null)
            <span class="{{ $rule->getScourged() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Scourged.png') }}">
            </span>
        @endif

        @if ($rule->getAnyEnchantment() !== null || $rule->getHasEnchantment() || $rule->getTransfiguredGem() !== null)
            <span
                class="{{ $rule->getAnyEnchantment() === false || $rule->getTransfiguredGem() === false ? 'decor-false' : '' }} {{ $rule->getHasEnchantment()  ? 'decor-counter' : '' }}"
                data-counter="{{ $rule->getHasEnchantment() ? $rule->getHasEnchantment()->value : null }}">
                <img class="img-contain" src="{{ asset('img/influences/Enchantment.webp') }}">
            </span>
        @endif

        @if ($rule->getHasExplicitMod()->numeric)
            <span class="decor-counter" data-counter="{{ max($rule->getHasExplicitMod()->numeric->value, count($rule->getHasExplicitMod()->array)) }}">
                <img class="img-contain" src="{{ asset('img/influences/Explicit.png') }}">
            </span>
        @endif

        @if ($rule->getHasSearingExarchImplicit())
            <span class="decor-counter" data-counter="{{ $rule->getHasSearingExarchImplicit()->value }}">
                <img class="img-contain" src="{{ asset('img/influences/Exarch.webp') }}">
            </span>
        @endif

        @if ($rule->getHasEaterOfWorldsImplicit())
            <span class="decor-counter" data-counter="{{ $rule->getHasEaterOfWorldsImplicit()->value }}">
                <img class="img-contain" src="{{ asset('img/influences/Eater.webp') }}">
            </span>
        @endif

        @if ($rule->getDeliriumItem() || $rule->getEnchantmentPassiveNode() || $rule->getEnchantmentPassiveNum())
            <span class="decor-counter" data-counter="{{ $rule->getEnchantmentPassiveNum() ? $rule->getEnchantmentPassiveNum()->value : '' }}">
                <img class="img-contain" src="{{ asset('img/influences/Delirium.png') }}">
            </span>
        @endif

        @if ($rule->getMirrored() !== null)
            <span class="{{ $rule->getMirrored() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Mirrored.webp') }}">
            </span>
        @endif

        @if ($rule->getCorrupted() !== null || $rule->getCorruptedMods())
            <span
                class="{{ $rule->getCorrupted() === false ? 'decor-false' : '' }} {{ $rule->getCorruptedMods()  ? 'decor-counter' : '' }}"
                data-counter="{{ $rule->getCorruptedMods() ? $rule->getCorruptedMods()->value : null }}">
                <img class="img-contain" src="{{ asset('img/influences/Corrupted.webp') }}">
            </span>
        @endif

        @if ($rule->getIdentified() !== null)
            <span class="{{ $rule->getIdentified() ? '' : 'decor-false' }}">
                <img class="img-contain" src="{{ asset('img/influences/Identified.webp') }}">
            </span>
        @endif

        @if ($rule->getMapItem() === true)
            <img class="img-contain" src="{{ asset('img/influences/Map.png') }}">
        @endif
    </div>
</div>
