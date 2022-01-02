<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Resource\Id;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Wonder\Id as Wid;
use SplObjectStorage;

class Bank
{
    public int $discardReward = self::DEFAULT_DISCARD_REWARD;

    /**
     * @var SplObjectStorage | array<Cid, int>
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    public SplObjectStorage $cardPrice;

    /**
     * @var SplObjectStorage | array<Wid, int>
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    public SplObjectStorage $wonderPrice;

    /**
     * @var SplObjectStorage | array<Rid, int>
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    public SplObjectStorage $resourcePrice;

    private const DEFAULT_DISCARD_REWARD = 2;
    private const DEFAULT_RESOURCE_PRICE = 2;
    private const FIXED_RESOURCE_PRICE = 1;

    public function __construct()
    {
        $this->cardPrice = new SplObjectStorage();
        $this->wonderPrice = new SplObjectStorage();
        $this->resourcePrice = new SplObjectStorage();

        foreach (Rid::cases() as $rid) {
            $this->resourcePrice[$rid] = self::DEFAULT_RESOURCE_PRICE;
        }
    }

    public function hasFixedResourcePrice(Rid $resource): bool
    {
        return $this->resourcePrice[$resource] === self::FIXED_RESOURCE_PRICE;
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
