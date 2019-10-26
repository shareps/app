<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Task;

use App\Entity\Parking\Member;
use App\Entity\Parking\MemberNeed;
use App\Entity\Parking\Reservation;
use App\Enum\Functional\ApplicationEnum;
use App\Repository\Functional\ParkingReservationRepository;

class ReserveDaysProperties
{
    /** @var array|\DateTimeImmutable[] */
    private $dates = [];
    /** @var int */
    private $placesCount = 0;
    /** @var array|int[] */
    private $placesCountByDate = [];
    /** @var array */
    private $reservationsByDate = [];
    /** @var array|array[] */
    private $membersByDate = [];
    /** @var array|array[] */
    private $membersNeedsByDate = [];
    /** @var ParkingReservationRepository */
    protected $parkingReservationRepository = [];
    /** @var array|Member[] */
    private $membersSortedByPoints = [];
    /** @var array */
    private $membersNeedsByMemberAndDate = [];
    /** @var array */
    private $reservationsByMemberAndDate = [];
    /** @var array */
    private $membershipDatesByMember = [];

    // -----------------------------------------------------------------------------------------------------------------

    public function __construct(ParkingReservationRepository $parkingReservationRepository)
    {
        $this->parkingReservationRepository = $parkingReservationRepository;
    }

    // -----------------------------------------------------------------------------------------------------------------

    public function calculate(\DateTimeImmutable ...$dates): void
    {
        $this->dates = $dates;
        if (0 === \count($this->dates)) {
            return;
        }

        $this->retrieveDataFromDatabase();
        $this->calculateDataFromDatabase();
    }

    public function getDates(): array
    {
        return $this->dates;
    }

    public function getPlacesCountSummary(): int
    {
        return $this->placesCount;
    }

    public function getPlacesCountByDate(): array
    {
        return $this->placesCountByDate;
    }

    public function getMembersSortedByPoints(): array
    {
        return $this->membersSortedByPoints;
    }

    public function getMemberNeedForMemberAndDate(Member $member, \DateTimeImmutable $date): ?MemberNeed
    {
        $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

        return $this->membersNeedsByMemberAndDate[$member->getId()][$dateString] ?? null;
    }

    public function getReservationForMemberAndDate(Member $member, \DateTimeImmutable $date): ?Reservation
    {
        $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

        return $this->reservationsByMemberAndDate[$member->getId()][$dateString] ?? null;
    }

    public function isMembershipForMemberAndDate(Member $member, \DateTimeImmutable $date): bool
    {
        $membershipDatesForMember = $this->membershipDatesByMember[$member->getId()] ?? [];
        $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

        return \array_key_exists($dateString, $membershipDatesForMember);
    }

    // -----------------------------------------------------------------------------------------------------------------

    private function retrieveDataFromDatabase(): void
    {
        foreach ($this->dates as $date) {
            $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

            $this->placesCountByDate[$dateString] = $this->parkingReservationRepository
                ->getPlacesCountAvailableForDate($date);
            $this->reservationsByDate[$dateString] = $this->parkingReservationRepository
                ->getReservationsForDate($date);
            $this->membersByDate[$dateString] = $this->parkingReservationRepository
                ->getMembersWithMembershipForDate($date);
            $this->membersNeedsByDate[$dateString] = $this->parkingReservationRepository
                ->getMembersNeedsForDate($date);
        }
    }

    private function calculateDataFromDatabase(): void
    {
        $this->calculatePlacesCount();
        $this->calculateMembersSortedByPoints();
        $this->calculateMembersNeedsByMemberAndDate();
        $this->calculateMembershipDatesByMember();
        $this->calculateReservationsByMemberAndDate();
    }

    private function calculatePlacesCount(): void
    {
        $this->placesCount = 0;
        foreach ($this->placesCountByDate as $count) {
            $this->placesCount += $count;
        }
    }

    private function calculateMembersSortedByPoints(): void
    {
        $this->membersSortedByPoints = [];
        foreach ($this->membersByDate as $members) {
            /** @var Member $member */
            foreach ($members as $member) {
                $this->membersSortedByPoints[$member->getId()] = $member;
            }
        }
        usort($this->membersSortedByPoints, [$this, 'sortMembersArrayForBestMember']);
    }

    private static function sortMembersArrayForBestMember(Member $a, Member $b): int
    {
        return $a->getPoints() - $b->getPoints();
    }

    private function calculateMembersNeedsByMemberAndDate(): void
    {
        $this->membersNeedsByMemberAndDate = [];
        foreach ($this->membersNeedsByDate as $dateString => $membersNeeds) {
            /** @var MemberNeed $memberNeed */
            foreach ($membersNeeds as $memberNeed) {
                $this->membersNeedsByMemberAndDate[$memberNeed->getMember()->getId()][$dateString] = $memberNeed;
            }
        }
    }

    private function calculateReservationsByMemberAndDate(): void
    {
        $this->reservationsByMemberAndDate = [];
        foreach ($this->reservationsByDate as $dateString => $reservations) {
            /** @var Reservation $reservation */
            foreach ($reservations as $reservation) {
                $this->reservationsByMemberAndDate[$reservation->getMember()->getId()][$dateString] = $reservation;
            }
        }
    }

    private function calculateMembershipDatesByMember(): void
    {
        $this->membershipDatesByMember = [];
        /** @var Member $member */
        foreach ($this->membersByDate as $dateString => $member) {
            $this->membershipDatesByMember[$member->getId()][$dateString] = [$dateString];
        }
    }
}
