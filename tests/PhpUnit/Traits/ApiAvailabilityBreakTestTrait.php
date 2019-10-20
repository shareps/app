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
trait ApiAvailabilityBreakTestTrait
{
    protected function apiAvailabilityBreaksGetCollection(KernelBrowser $client): Response
    {
        $client->request(
            'GET',
            '/api/availability/breaks',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilityBreaksGet(KernelBrowser $client, string $availabilityId): Response
    {
        $client->request(
            'GET',
            sprintf('/api/availability/breaks/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilityBreaksDelete(KernelBrowser $client, string $availabilityId): Response
    {
        $client->request(
            'DELETE',
            sprintf('/api/availability/breaks/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilityBreaksPost(KernelBrowser $client, array $changedArguments = []): Response
    {
        $arguments = $this->apiAvailabilityBreaksBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'POST',
            '/api/availability/breaks',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiAvailabilityBreaksPut(KernelBrowser $client, string $availabilityId, array $changedArguments = []): Response
    {
        $arguments = $this->apiAvailabilityBreaksBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'PUT',
            sprintf('/api/availability/breaks/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiAvailabilityBreaksBasePostData(): array
    {
        $year = ((int) date('Y')) - 1;

        return $this->apiAvailabilityBreaksFakePostData($year);
    }

    protected function apiAvailabilityBreaksFakePostData(int $year): array
    {
        return [
            'places' => 100,
            'reason' => 'test',
            'date' => sprintf('%s-01-01', $year),
        ];
    }
}
