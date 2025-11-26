<?php

class CombatService
{
    public function computeInitiative(Hero $hero, Monster $monster): string
    {
        $heroInit    = rand(1, 6) + $hero->initiative;
        $monsterInit = rand(1, 6) + $monster->initiative;

        if ($heroInit === $monsterInit) {
            return $hero->class === 'Voleur' ? 'hero' : 'monster';
        }

        return $heroInit > $monsterInit ? 'hero' : 'monster';
    }

    public function physicalAttack(object $attacker, object $defender, ?string $defenderClass = null): array
    {
        $weaponBonus = property_exists($attacker, 'weapon_bonus') ? (int)$attacker->weapon_bonus : 0;
        $armorBonus  = property_exists($defender, 'armor_bonus')  ? (int)$defender->armor_bonus  : 0;

        $attackRoll  = rand(1, 6);
        $attackValue = $attackRoll + $attacker->strength + $weaponBonus;

        $defenseRoll = rand(1, 6);
        if ($defenderClass === 'Voleur') {
            $defenseValue = $defenseRoll + (int)($defender->initiative / 2) + $armorBonus;
        } else {
            $defenseValue = $defenseRoll + (int)($defender->strength / 2) + $armorBonus;
        }

        $damage = max(0, $attackValue - $defenseValue);
        $defender->pv -= $damage;
        if ($defender->pv < 0) {
            $defender->pv = 0;
        }

        return [
            'damage'      => $damage,
            'attackRoll'  => $attackRoll,
            'defenseRoll' => $defenseRoll,
            'attackValue' => $attackValue,
            'defenseValue'=> $defenseValue,
        ];
    }
}

?>