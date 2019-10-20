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

class V050AddReservationsTest extends AcceptanceTestCase
{
    public function test_addFromFixture(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        foreach ($this->getFixturesData()['reservations'] as $userEmail => $reservationData) {
            $member = $this->getPermissionMemberByEmail(self::$entityManager, $userEmail);
            $reservationData['member'] = $member->getId();
            $response = $this->apiReservationsPost(self::$client, $reservationData);

            $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        }
    }
}
