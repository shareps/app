<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V003AddPermissionMembersTest extends AcceptanceTestCase
{
    public function test_addPermissionMembers(): void
    {
        $this->assertAddPermissionMembers(self::$container, $this->getFixturesData());
    }
}
