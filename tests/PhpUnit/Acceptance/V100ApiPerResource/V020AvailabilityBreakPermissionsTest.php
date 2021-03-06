<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V100ApiPerResource;

use App\Enum\Functional\PermissionEnum;
use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;
use Symfony\Component\HttpFoundation\Response;

class V020AvailabilityBreakPermissionsTest extends AcceptanceTestCase
{
    protected static $resourceIds = [];
    protected static $availabilityFakeYear = 1900;

    public function test_permissions(): void
    {
        $this->assertAnonymousActions();
        $this->assertInitialDataExist();
        foreach (RoleEnum::toArray() as $requesterRole) {
            $this->assertAllPermissionsForOneRole($requesterRole);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    private function assertAnonymousActions(): void
    {
        $response = $this->apiAvailabilityBreaksPost(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiAvailabilityBreaksGetCollection(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiAvailabilityBreaksGet(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiAvailabilityBreaksDelete(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());
    }

    private function assertInitialDataExist(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);
        $response = $this->apiAvailabilityBreaksPost(self::$client);

        $this->assertEquals(201, $response->getStatusCode());

        $itemData = $this->jsonDecode($response->getContent());
        self::$resourceIds[$itemData['id']] = $itemData;
    }

    private function assertAllPermissionsForOneRole(string $requesterRole): void
    {
        $this->apiLogInRole($requesterRole);
        $this->assertCreatePermissionForOneRole($requesterRole);
        $this->assertReadPermissionForOneRole($requesterRole);
        $this->assertUpdatePermissionForOneRole($requesterRole);
    }

    private function assertCreatePermissionForOneRole(string $requesterRole): void
    {
        $isPermitted = self::$configurationService->hasPermissionBoolean(
            PermissionEnum::PARKING_AVAILABILITY_BREAK_CREATE(),
            new RoleEnum($requesterRole)
        );

        $fakeData = $this->apiAvailabilityBreaksFakePostData($this->calculateFakeYear());
        $response = $this->apiAvailabilityBreaksPost(self::$client, $fakeData);
        $this->assertEquals($isPermitted ? 201 : 403, $response->getStatusCode(), $requesterRole . '-' . $fakeData['date']);
        if ($isPermitted) {
            $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
            $itemData = $this->jsonDecode($response->getContent());
            self::$resourceIds[$itemData['id']] = $itemData;
        }
    }

    private function assertReadPermissionForOneRole(string $requesterRole): void
    {
        $isPermitted = self::$configurationService->hasPermissionBoolean(
            PermissionEnum::PARKING_AVAILABILITY_BREAK_READ(),
            new RoleEnum($requesterRole)
        );
        $response = $this->apiAvailabilityBreaksGetCollection(self::$client);
        $this->assertEquals($isPermitted ? Response::HTTP_OK : Response::HTTP_FORBIDDEN, $response->getStatusCode(), $requesterRole);

        $firstId = $this->jsonDecode($response->getContent())[0]['id'] ?? sprintf('response%s', $response->getStatusCode());

        $response = $this->apiAvailabilityBreaksGet(self::$client, $firstId);
        $this->assertEquals($isPermitted ? Response::HTTP_OK : Response::HTTP_NOT_FOUND, $response->getStatusCode(), $requesterRole . '-' . $firstId);
        if ($isPermitted) {
            $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
            $itemData = $this->jsonDecode($response->getContent());
            self::$resourceIds[$itemData['id']] = $itemData;
        }
    }

    private function assertUpdatePermissionForOneRole(string $requesterRole): void
    {
        $isPermitted = self::$configurationService->hasPermissionBoolean(
            PermissionEnum::PARKING_AVAILABILITY_BREAK_UPDATE(),
            new RoleEnum($requesterRole)
        );

        $itemData = reset(self::$resourceIds);
        $itemId = $itemData['id'];
        $requestData = $itemData;
        $requestData['places'] += 10;
        unset($requestData['id']);
        $response = $this->apiAvailabilityBreaksPut(self::$client, $itemId, $requestData);
        $this->assertEquals($isPermitted ? Response::HTTP_OK : Response::HTTP_FORBIDDEN, $response->getStatusCode(), $requesterRole);
        if ($isPermitted) {
            $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
            $itemData = $this->jsonDecode($response->getContent());
            self::$resourceIds[$itemData['id']] = $itemData;
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    private function calculateFakeYear(): int
    {
        ++self::$availabilityFakeYear;

        return self::$availabilityFakeYear;
    }
}
