<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Card\Id as Cid;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Rule;
use App\Domain\Game\Wonder\Id as Wid;
use SplObjectStorage;

class Bank
{
    public int $discardReward = Rule::DEFAULT_DISCARD_REWARD;

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

    public function __construct()
    {
        $this->cardPrice = new SplObjectStorage();
        $this->wonderPrice = new SplObjectStorage();
        $this->resourcePrice = new SplObjectStorage();

        foreach (Rid::cases() as $rid) {
            $this->resourcePrice[$rid] = Rule::DEFAULT_RESOURCE_PRICE;
        }
    }

    public function hasFixedResourcePrice(Rid $resource): bool
    {
        return $this->resourcePrice[$resource] === Rule::FIXED_RESOURCE_PRICE;
    }
}
