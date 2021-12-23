<?php

namespace App\Domain\Attr;

use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Don't forget add ORM\HasLifecycleCallbacks to parent!
 */
trait UpdatedAtAttribute
{
    #[ORM\Column(type:'datetime_immutable')]
    protected CarbonImmutable $updated_at;

    public function setUpdatedAt(CarbonImmutable $updated_at = null): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return CarbonImmutable
     */
    public function getUpdatedAt(): CarbonImmutable
    {
        return $this->updated_at;
    }

    #[
        ORM\PrePersist,
        ORM\PreUpdate,
    ]
    public function autoSetUpdateAt(): void
    {
        $this->updated_at = CarbonImmutable::now();
    }
}
