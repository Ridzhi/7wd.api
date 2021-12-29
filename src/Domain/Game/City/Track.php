<?php

namespace App\Domain\Game\City;

class Track
{
    public int $pos = 0;
    public int $maxZone = 0;

    private const CAPITAL_POS = 9;

    /**
     * @var array<int, array{startPos: int, points: int, fine: int}>
     */
    private array $zones = [
        0 => [
            'startPos' => 0,
            'points' => 0,
            'fine' => 0,
        ],
        1 => [
            'startPos' => 1,
            'points' => 2,
            'fine' => 0,
        ],
        2 => [
            'startPos' => 3,
            'points' => 5,
            'fine' => 2,
        ],
        3 => [
            'startPos' => 6,
            'points' => 10,
            'fine' => 5,
        ],
    ];

    /**
     * @param int $power
     * @param Track $enemy
     * @return array{fine: int, supremacy: bool}
     */
    public function moveConflictPawn(int $power, Track $enemy): array
    {
        $result = [
            'fine' => 0,
            'supremacy' => false,
        ];

        if ($enemy->pos >= $power) {
            $enemy->pos -= $power;

            return $result;
        }

        $this->pos += ($power - $enemy->pos);
        $enemy->pos = 0;

        if ($this->pos >= self::CAPITAL_POS) {
            $this->pos = self::CAPITAL_POS;
            $result['supremacy'] = true;
        }

        if (($ind = $this->getZoneIndex($this->pos)) > $this->maxZone) {
            $this->maxZone = $ind;
            $result['fine'] = $this->zones[$ind]['fine'];
        }

        return $result;
    }

    public function getZoneIndex(int $pos): int
    {
        foreach (array_reverse($this->zones, true) as $index => $zone) {
            if ($pos >= $zone['startPos']) {
                return $index;
            }
        }

        return 0;
    }
}
