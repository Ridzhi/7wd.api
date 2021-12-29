<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Resource\Id as Rid;

class Bank
{
    public int $discardReward = self::DEFAULT_DISCARD_REWARD;
    public array $cardPrice = [];
    public array $wonderPrice = [];
    public array $resourcePrice = [];

    private const DEFAULT_DISCARD_REWARD = 2;
    private const DEFAULT_RESOURCE_PRICE = 2;
    private const FIXED_RESOURCE_PRICE = 1;

    public function __construct()
    {
        foreach (Rid::cases() as $rid) {
            $this->resourcePrice[$rid->value] = self::DEFAULT_RESOURCE_PRICE;
        }
    }

    public function hasFixedResourcePrice(Rid $resource): bool
    {
        return $this->resourcePrice[$resource->value] === self::FIXED_RESOURCE_PRICE;
    }

    /**
     * @return array<int>
     */
    public function getDiscountPriority(): array
    {
        $data = $this->resourcePrice;
        arsort($data, SORT_NUMERIC);

        return array_keys($data);
    }
}
