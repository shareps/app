<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Entity\Traits;

use App\Entity\Traits;

class DummyEntity
{
    use Traits\PropertyIdGeneratedTrait;
    use Traits\PropertyActiveStrictTrait;
    use Traits\PropertyCodeStrictTrait;

    public function __construct()
    {
        $this->id = 'test';
    }
}
