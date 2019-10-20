<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V200ApiFull;

use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V040AddMemberNeedsTestTMP extends AcceptanceTestCase
{
    public function test_addFromFixture(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        foreach ($this->getFixturesData()['memberNeeds'] as $memberNeedData) {
            $response = $this->apiMemberNeedsPost(self::$client, $memberNeedData);

            $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        }
    }
}
