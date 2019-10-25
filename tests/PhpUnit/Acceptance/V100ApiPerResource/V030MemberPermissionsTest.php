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

class V030MemberPermissionsTest extends AcceptanceTestCase
{
    protected static $resourceIds = [];

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
        $response = $this->apiMembersPost(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiMembersGetCollection(self::$client);
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiMembersGet(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());

        $response = $this->apiMembersDelete(self::$client, 'fake');
        $this->assertEquals(403, $response->getStatusCode());
    }

    private function assertInitialDataExist(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);
        $response = $this->apiMembersPost(self::$client);

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
            $fakeData = $this->apiMembersFakePostData($subjectRole);
            $response = $this->apiMembersPost(self::$client, $fakeData);
            $this->assertEquals(
                $isPermitted ? Response::HTTP_CREATED : Response::HTTP_FORBIDDEN,
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

        $response = $this->apiMembersGetCollection(self::$client);
        $this->assertEquals(
            $isPermitted ? Response::HTTP_OK : Response::HTTP_FORBIDDEN,
            $response->getStatusCode(),
            $requesterRole
        );

        $firstId = $this->jsonDecode($response->getContent())[0]['id'] ?? sprintf(
                'response%s',
                $response->getStatusCode()
            );

        $response = $this->apiMembersGet(self::$client, $firstId);
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
        $itemData = reset(self::$resourceIds);
        $itemId = $itemData['id'];

        $requestData['name'] = $itemData['name'];
        $requestData['role'] = $itemData['role'];

        foreach (RoleEnum::toArray() as $subjectRole) {
            $isPermitted = self::$configurationService->hasPermissionRole(
                PermissionEnum::PARKING_MEMBER_UPDATE(),
                new RoleEnum($requesterRole),
                new RoleEnum($subjectRole)
            );
            $requestData['role'] = $subjectRole;

            $response = $this->apiMembersPut(self::$client, $itemId, $requestData);
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
}
