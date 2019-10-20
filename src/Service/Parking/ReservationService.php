<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Service\Parking;

use App\Entity\Parking\Member;
use App\Entity\Parking\Reservation;
use App\Enum\Entity\ReservationTypeEnum;
use App\Enum\Functional\PermissionEnum;
use App\Repository\Entity\Parking\ReservationRepository;
use App\Traits\AssertTrait;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ReservationService
{
    use AssertTrait;

    /** @var ReservationRepository */
    private $reservationRepository;
    /** @var ValidatorInterface */
    private $validator;
    /** @var Security */
    private $security;

    public function __construct(ReservationRepository $reservationRepository, ValidatorInterface $validator, Security $security)
    {
        $this->reservationRepository = $reservationRepository;
        $this->validator = $validator;
        $this->security = $security;
    }

    public function updateReservation(
        Reservation $reservation,
        int $places,
        ReservationTypeEnum $reservationTypeEnum
    ): Reservation {
        $reservation->setPlaces($places);
        $reservation->setType($reservationTypeEnum);
        $this->assertIsValidObject($this->validator, $reservation);
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_RESERVATION_UPDATE, $reservation);

        $this->reservationRepository->saveAll($reservation);

        return $reservation;
    }

    public function createReservation(
        Member $member,
        \DateTimeImmutable $date,
        int $places,
        ReservationTypeEnum $reservationTypeEnum
    ): Reservation {
        $reservation = new Reservation(
            $member,
            $date,
            $places,
            $reservationTypeEnum
        );
        $this->assertIsValidObject($this->validator, $reservation);
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_RESERVATION_CREATE, $reservation);

        return $reservation;
    }

    public function deleteReservation(
        Reservation $reservation
    ): Reservation {
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_RESERVATION_DELETE, $reservation);

        $this->reservationRepository->deleteAll($reservation);

        return $reservation;
    }
}
