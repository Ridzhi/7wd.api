<?php

namespace App\Domain\Attr;

trait  MetaTimeAttributePack
{
    use CreatedAtAttribute;
    use UpdatedAtAttribute;
    use DeletedAtAttribute;
}
