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

class V030AddMembersTest extends AcceptanceTestCase
{
    public function test_addFromFixture(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        foreach ($this->getFixturesData()['members'] as $memberData) {
            $response = $this->apiMembersPost(self::$client, $memberData);

            $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        }
    }
}
