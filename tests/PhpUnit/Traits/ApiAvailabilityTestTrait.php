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
trait ApiAvailabilityTestTrait
{
    protected function apiAvailabilitiesGetCollection(KernelBrowser $client): Response
    {
        $client->request(
            'GET',
            '/api/availabilities',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilitiesGet(KernelBrowser $client, string $availabilityId): Response
    {
        $client->request(
            'GET',
            sprintf('/api/availabilities/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilitiesDelete(KernelBrowser $client, string $availabilityId): Response
    {
        $client->request(
            'DELETE',
            sprintf('/api/availabilities/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiAvailabilitiesPost(KernelBrowser $client, array $changedArguments = []): Response
    {
        $arguments = $this->apiAvailabilitiesBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'POST',
            '/api/availabilities',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiAvailabilitiesPut(KernelBrowser $client, string $availabilityId, array $changedArguments = []): Response
    {
        $arguments = $this->apiAvailabilitiesBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'PUT',
            sprintf('/api/availabilities/%s', $availabilityId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiAvailabilitiesBasePostData(): array
    {
        $year = ((int) date('Y')) - 1;

        return $this->apiAvailabilitiesFakePostData((int) $year);
    }

    protected function apiAvailabilitiesFakePostData(int $year): array
    {
        return [
            'places' => 100,
            'fromDate' => sprintf('%s-01-01', $year),
            'toDate' => sprintf('%s-12-31', $year),
        ];
    }
}
