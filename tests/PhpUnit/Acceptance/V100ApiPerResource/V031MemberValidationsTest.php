<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V100ApiPerResource;

use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V031MemberValidationsTest extends AcceptanceTestCase
{
    protected static $resourceId = '';
    protected static $resourceData = [];

    public function test_getCollection(): void
    {
        $this->apiLogInRole(RoleEnum::SYSTEM);

        $response = $this->apiMembersGetCollection(self::$client);

        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function test_addApiMemberWithEmptyEmail(): void
    {
        $response = $this->apiMembersPost(self::$client, ['email' => '']);
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function test_addApiMemberWithEmptyName(): void
    {
        $response = $this->apiMembersPost(self::$client, ['name' => '']);
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function test_addApiMemberWithEmptyRole(): void
    {
        $response = $this->apiMembersPost(self::$client, ['role' => '']);
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function test_addApiMemberFirstTime(): void
    {
        self::$resourceData = $this->apiMembersFakePostData(RoleEnum::MEMBER);

        $response = $this->apiMembersPost(self::$client, self::$resourceData);

        $this->assertEquals(201, $response->getStatusCode(), $response->getContent());
        $itemData = $this->jsonDecode($response->getContent());
        self::$resourceId = $itemData['id'];
    }

    public function test_addApiMemberWithTheSameEmail(): void
    {
        $response = $this->apiMembersPost(self::$client, self::$resourceData);
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }

    public function test_updateApiMember(): void
    {
        $response = $this->apiMembersPut(self::$client, self::$resourceId, self::$resourceData);
        $this->assertEquals(200, $response->getStatusCode(), $response->getContent());
    }

    public function test_updateApiMemberWithEmptyName(): void
    {
        $response = $this->apiMembersPut(self::$client, self::$resourceId, ['name' => '']);
        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
    }
}
