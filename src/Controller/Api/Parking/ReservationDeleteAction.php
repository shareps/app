<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Controller\Api\Parking;

use App\Entity\Parking\Reservation;
use App\Service\Parking\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationDeleteAction extends AbstractController
{
    /** @var ReservationService */
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function __invoke(Reservation $data): void
    {
        $this->reservationService->deleteReservation($data);
    }
}
