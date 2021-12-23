<?php

namespace App\Domain\Attr;

use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Don't forget add ORM\HasLifecycleCallbacks to parent!
 */
trait CreatedAtAttribute
{
    #[ORM\Column(type: 'datetime_immutable')]
    protected CarbonImmutable $created_at;

    public function setCreatedAt(CarbonImmutable $created_at = null): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return CarbonImmutable
     */
    public function getCreatedAt(): CarbonImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function autoSetCreatedAt(): void
    {
        $this->created_at = CarbonImmutable::now();
    }
}
