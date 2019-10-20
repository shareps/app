<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

/**
 * @mixin AcceptanceTestCase
 */
trait ApiMemberTestTrait
{
    protected function apiMembersGetCollection(KernelBrowser $client): Response
    {
        $client->request(
            'GET',
            '/api/members',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMembersGet(KernelBrowser $client, string $memberId): Response
    {
        $client->request(
            'GET',
            sprintf('/api/members/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMembersDelete(KernelBrowser $client, string $memberId): Response
    {
        $client->request(
            'DELETE',
            sprintf('/api/members/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMembersPost(KernelBrowser $client, array $changedArguments = []): Response
    {
        $arguments = $this->apiMembersBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'POST',
            '/api/members',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiMembersPut(KernelBrowser $client, string $memberId, array $changedArguments = []): Response
    {
        $arguments = $this->apiMembersBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'PUT',
            sprintf('/api/members/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiMembersBasePostData(): array
    {
        return [
            'name' => 'MemberAddTest',
            'role' => 'ROLE_MEMBER',
            'email' => 'MemberAddTest@localhost.local',
        ];
    }

    protected function apiMembersFakePostData(string $role): array
    {
        $faker = \Faker\Factory::create();

        return [
            'name' => $faker->name,
            'role' => $role,
            'email' => $faker->email,
        ];
    }
}
