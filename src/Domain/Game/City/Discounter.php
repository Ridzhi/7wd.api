<?php

namespace App\Domain\Game\City;

use App\Domain\Game\Discount\Context;
use App\Domain\Game\Discount\Discount;
use App\Domain\Game\Resource\Storage;

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
     * @param array $priority
     * @return void
     */
    public function discount(Context $context, Storage $cost, array $priority): void
    {
        foreach ($this->list as $discount) {
            if ($discount->isSupport($context)) {
                $discount->discount($cost, $priority);
            }
        }
    }
}
