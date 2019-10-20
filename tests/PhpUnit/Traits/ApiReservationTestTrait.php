<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use App\Enum\Entity\ReservationTypeEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

/**
 * @mixin AcceptanceTestCase
 */
trait ApiReservationTestTrait
{
    protected function apiReservationsGetCollection(KernelBrowser $client): Response
    {
        $client->request(
            'GET',
            '/api/reservations',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiReservationsGet(KernelBrowser $client, string $reservationId): Response
    {
        $client->request(
            'GET',
            sprintf('/api/reservations/%s', $reservationId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiReservationsDelete(KernelBrowser $client, string $reservationId): Response
    {
        $client->request(
            'DELETE',
            sprintf('/api/reservations/%s', $reservationId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json']
        );

        return $client->getResponse();
    }

    protected function apiReservationsPost(KernelBrowser $client, array $changedArguments = []): Response
    {
        $arguments = $this->apiReservationsBasePostData($changedArguments['member']);
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'POST',
            '/api/reservations',
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiReservationsPut(KernelBrowser $client, string $reservationId, array $changedArguments = []): Response
    {
        $arguments = $this->apiReservationsBasePostData();
        $arguments = array_merge($arguments, $changedArguments);

        $client->request(
            'PUT',
            sprintf('/api/reservations/%s', $reservationId),
            [],
            [],
            ['HTTP_ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'],
            $this->jsonEncode($arguments)
        );

        return $client->getResponse();
    }

    protected function apiReservationsBasePostData(string $memberId): array
    {
        $dateString = date('Y') . '-01-01';

        return $this->apiReservationsFakePostData($memberId, $dateString);
    }

    protected function apiReservationsFakePostData(string $memberId, string $dateString): array
    {
        return [
            'date' => $dateString,
            'type' => ReservationTypeEnum::ASSIGNED,
            'places' => 1,
            'member' => $memberId,
        ];
    }
}
