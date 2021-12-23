<?php

namespace App\Domain\Attr;

use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

trait DeletedAtAttribute
{
    #[ORM\Column(type:'datetime_immutable', nullable: true)]
    protected ?CarbonImmutable $deleted_at = null;

    /**
     * @param CarbonImmutable|null $deleted_at
     * @return $this
     */
    public function setDeletedAt(?CarbonImmutable $deleted_at = null): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return CarbonImmutable|null
     */
    public function getDeletedAt(): ?CarbonImmutable
    {
        return $this->deleted_at;
    }
}
