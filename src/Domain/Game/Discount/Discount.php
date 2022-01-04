<?php

namespace App\Domain\Game\Discount;

use App\Domain\Game\Resource\Id as Rid;
use App\Domain\Game\Resource\Storage;

class Discount
{
    /**
     * @var array<Rid>
     */
    private array $resources;

    public function __construct(
        private Context   $context,
        private int       $count,
        Rid               ...$resource,
    )
    {
        $this->resources = $resource;
    }

    public function isSupport(Context $context): bool
    {
        if ($this->context === Context::Global) {
            return true;
        }

        return $this->context === $context;
    }

    /**
     * @param Storage $cost
     * @param array<Rid> $priority Higher to lower price
     */
    public function discount(Storage $cost, array $priority): void
    {
        $count = $this->count;

        foreach (array_intersect($priority, $this->resources) as $rid) {
            if (!isset($cost[$rid])) {
                continue;
            }

            $discount = min($cost[$rid], $count);
            $count -= $discount;
            $cost[$rid] -= $discount;

            if (!$count) {
                break;
            }
        }
    }
}
