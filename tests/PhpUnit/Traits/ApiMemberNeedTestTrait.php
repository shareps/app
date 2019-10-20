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
trait ApiMemberNeedTestTrait
{
    protected function apiMemberNeedsGetCollection(KernelBrowser $client): Response
    {
        $client->request(
            'GET',
            '/api/member/needs',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMemberNeedsGet(KernelBrowser $client, string $memberId): Response
    {
        $client->request(
            'GET',
            sprintf('/api/member/needs/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMemberNeedsDelete(KernelBrowser $client, string $memberId): Response
    {
        $client->request(
            'DELETE',
            sprintf('/api/member/needs/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiMemberNeedsPost(KernelBrowser $client, array $changedArguments = []): Response
    {
        $arguments = $this->apiMembersBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'POST',
            '/api/member/needs',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiMemberNeedsPut(KernelBrowser $client, string $memberId, array $changedArguments = []): Response
    {
        $arguments = $this->apiMembersBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'PUT',
            sprintf('/api/member/needs/%s', $memberId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiMemberNeedsBasePostData(string $memberId): array
    {
        $year = ((int) date('Y')) - 1;

        return $this->apiMemberNeedsFakePostData($memberId, $year);
    }

    protected function apiMemberNeedsFakePostData(string $memberId, int $year): array
    {
        return [
            'member' => $memberId,
            'date' => sprintf('%s-01-01', $year),
            'places' => 0,
            'reason' => 'test',
        ];
    }
}
