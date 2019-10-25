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

class V050ReservationPermissionsTestTMP extends AcceptanceTestCase
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
        $response = $this->apiReservationsPost(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiReservationsGetCollection(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiReservationsGet(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiReservationsDelete(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());
    }

    private function assertInitialDataExist(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);
        $response = $this->apiReservationsPost(self::$client);

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
        foreach (RoleEnum::toArray() as $subjectRole) {
            $isPermitted = self::$configurationService->hasPermissionRole(
                PermissionEnum::PARKING_MEMBER_CREATE(),
                new RoleEnum($requesterRole),
                new RoleEnum($subjectRole)
            );
            $fakeData = $this->apiReservationsFakePostData($subjectRole);
            $response = $this->apiReservationsPost(self::$client, $fakeData);
            $this->assertEquals(
                $isPermitted ? 201 : 403,
                $response->getStatusCode(),
                $requesterRole.' - '.$subjectRole
            );
            if ($isPermitted) {
                $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
                $itemData = $this->jsonDecode($response->getContent());
                self::$resourceIds[$itemData['id']] = $itemData;
            }
        }
    }

    private function assertReadPermissionForOneRole(string $requesterRole): void
    {
        $isPermitted = self::$configurationService->hasPermissionBoolean(
            PermissionEnum::PARKING_MEMBER_READ(),
            new RoleEnum($requesterRole)
        );

        $response = $this->apiReservationsGetCollection(self::$client);
        $this->assertEquals(
            $isPermitted ? Response::HTTP_OK : Response::HTTP_FORBIDDEN,
            $response->getStatusCode(),
            $requesterRole
        );

        $firstId = $this->jsonDecode($response->getContent())[0]['id'] ?? sprintf(
                'response%s',
                $response->getStatusCode()
            );

        $response = $this->apiReservationsGet(self::$client, $firstId);
        $this->assertEquals(
            $isPermitted ? Response::HTTP_OK : Response::HTTP_NOT_FOUND,
            $response->getStatusCode(),
            $requesterRole.'-'.$firstId
        );
        if ($isPermitted) {
            $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
            $itemData = $this->jsonDecode($response->getContent());
            self::$resourceIds[$itemData['id']] = $itemData;
        }
    }

    private function assertUpdatePermissionForOneRole(string $requesterRole): void
    {
        $isPermitted = self::$configurationService->hasPermissionBoolean(
            PermissionEnum::PARKING_RESERVATION_UPDATE(),
            new RoleEnum($requesterRole)
        );

        $itemData = reset(self::$resourceIds);
        $itemId = $itemData['id'];
        $requestData = $itemData;
        $requestData['places'] += 10;
        unset($requestData['id']);
        unset($requestData['points']);
        $response = $this->apiReservationsPut(self::$client, $itemId, $requestData);
        $this->assertEquals(
            $isPermitted ? Response::HTTP_OK : Response::HTTP_FORBIDDEN,
            $response->getStatusCode(),
            $requesterRole
        );
        if ($isPermitted) {
            $this->assertArrayHasKey('id', $this->jsonDecode($response->getContent()));
            $itemData = $this->jsonDecode($response->getContent());
            self::$resourceIds[$itemData['id']] = $itemData;
        }
    }
}
