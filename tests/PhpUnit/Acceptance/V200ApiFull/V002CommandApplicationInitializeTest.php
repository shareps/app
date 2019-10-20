<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V200ApiFull;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V002CommandApplicationInitializeTest extends AcceptanceTestCase
{
    public function test_commandApplicationInitialize(): void
    {
        $this->assertExecuteCommandApplicationInitialize(self::$application);
    }
}
