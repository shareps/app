<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V004AddInitialResoureDataTest extends AcceptanceTestCase
{
    public function test_addMemberResources(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        $response = $this->apiAvailabilitiesPost(self::$client);
        $this->assertEquals(201, $response->getStatusCode());

        $response = $this->apiMembersPost(self::$client);
        $this->assertEquals(201, $response->getStatusCode());
    }
}
