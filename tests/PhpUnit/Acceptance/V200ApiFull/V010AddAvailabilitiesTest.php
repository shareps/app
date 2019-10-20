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

class V010AddAvailabilitiesTest extends AcceptanceTestCase
{
    public function test_addFromFixture(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        foreach ($this->getFixturesData()['availabilities'] as $availabilityData) {
            $thisMondayDate = new \DateTimeImmutable('this monday');
            $requestData['places'] = $availabilityData['places'];
            $requestData['fromDate'] = $thisMondayDate->modify($availabilityData['fromDateModifier'])->format(ApplicationEnum::DATE_FORMAT);
            $requestData['toDate'] = $thisMondayDate->modify($availabilityData['toDateModifier'])->format(ApplicationEnum::DATE_FORMAT);

            $response = $this->apiAvailabilitiesPost(self::$client, $requestData);

            $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        }
    }
}
