<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V200ApiFull;

use App\Enum\Functional\ApplicationEnum;
use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V020AddAvailabilityBreaksTest extends AcceptanceTestCase
{
    public function test_addFromFixture(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        foreach ($this->getFixturesData()['availabilityBreaks'] as $availabilityBreakData) {
            $thisMondayDate = new \DateTimeImmutable('this monday');
            $requestData['places'] = $availabilityBreakData['places'];
            $requestData['date'] = $thisMondayDate->modify($availabilityBreakData['dateModifier'])->format(ApplicationEnum::DATE_FORMAT);
            $requestData['reason'] = 'test';

            $response = $this->apiAvailabilityBreaksPost(self::$client, $requestData);

            $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        }
    }
}
