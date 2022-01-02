<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Resource\Storage;
use SplObjectStorage;

class Discounter
{
    /**
     * @var array<Discount>
     */
    public array $list = [];

    public function add(Discount $discount): void
    {
        $this->list[] = $discount;
    }

    /**
     * @param Context $context
     * @param Storage $cost
     * @param SplObjectStorage|array<Rid, int> $priceList
     * @return void
     * @noinspection PhpDocSignatureInspection
     */
    public function discount(Context $context, Storage $cost, SplObjectStorage $priceList): void
    {
        $priority = $this->getPriority($priceList);

        foreach ($this->list as $discount) {
            if ($discount->isSupport($context)) {
                $discount->discount($cost, $priority);
            }
        }
    }

    /**
     * @param SplObjectStorage|array<Rid, int> $priceList
     * @return array<Rid>
     * @noinspection PhpDocSignatureInspection
     */
    private function getPriority(SplObjectStorage $priceList): array
    {
        arsort($priceList, SORT_NUMERIC);

        return array_keys($priceList);
    }
}
