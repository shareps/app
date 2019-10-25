<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

/**
 * @group current
 */
class V001TruncateDatabaseTest extends AcceptanceTestCase
{
    public function test_truncateDatabase(): void
    {
        $this->assertTruncateDatabase(self::$entityManager);
    }
}
