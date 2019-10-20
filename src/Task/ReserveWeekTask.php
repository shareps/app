<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Task;

use App\Entity\Accounting\Journal;
use App\Entity\Accounting\JournalMove;
use App\Entity\Accounting\Task;
use App\Entity\EntityInterface;
use App\Entity\Parking\Member;
use App\Entity\Parking\Reservation;
use App\Enum\Entity\JournalTypeEnum;
use App\Enum\Entity\ReservationTypeEnum;
use App\Enum\Entity\TaskTypeEnum;
use App\Enum\Functional\ApplicationEnum;
use App\Repository\Functional\ParkingReservationRepository;

class ReserveWeekTask extends AbstractTask
{
    /** @var ReserveDaysProperties|null */
    private $properties;
    /** @var array|EntityInterface[] */
    private $entitiesToSave = [];
    /** @var int */
    private $availablePlacesSummary = 0;
    /** @var array */
    private $availablePlacesByDate = [];

    // -----------------------------------------------------------------------------------------------------------------

    public function __construct(
        ParkingReservationRepository $parkingReservationRepository,
        ReserveDaysProperties $properties
    ) {
        parent::__construct($parkingReservationRepository);
        $this->properties = $properties;
    }

    // -----------------------------------------------------------------------------------------------------------------

    public function run(\DateTimeImmutable $weekAnyWorkdayDate): void
    {
        $weekWorkdaysDates = $this->getWeekWorkdaysDates($weekAnyWorkdayDate);
        $this->properties->calculate(...$weekWorkdaysDates);

        $this->processAllDatesForBestMembers();

        $this->parkingReservationRepository->saveAllInTransaction(...$this->entitiesToSave);
    }

    // -----------------------------------------------------------------------------------------------------------------

    private function processAllDatesForBestMembers(): void
    {
        $this->availablePlacesSummary = $this->properties->getPlacesCountSummary();
        $this->availablePlacesByDate = $this->properties->getPlacesCountByDate();

        $task = new Task(TaskTypeEnum::FILL());
        $this->parkingReservationRepository->saveAll($task);

        /** @var member $member */
        foreach ($this->properties->getMembersSortedByPoints() as $member) {
            if (0 === $this->availablePlacesSummary) {
                break;
            }
            if ($this->availablePlacesSummary < 0) {
                throw new \DomainException('Calculation error: availablePlacesSummary < 0');
            }
            if (array_sum($this->availablePlacesByDate) !== $this->availablePlacesSummary) {
                throw new \DomainException('Calculation error: availablePlacesSummary != count(availablePlacesByDate)');
            }

            $this->processAllDatesForMember($member, $task);
        }
    }

    private function processAllDatesForMember(Member $member, Task $task): void
    {
        $journal = new Journal($task, JournalTypeEnum::RESERVE());
        $this->entitiesToSave[] = $journal;

        $reservedPlaces = 0;
        /** @var \DateTimeImmutable $date */
        foreach ($this->properties->getDates() as $date) {
            $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

            if (0 === $this->availablePlacesSummary) {
                break;
            }
            if (0 === $this->availablePlacesByDate[$dateString]) {
                continue;
            }

            $reservedPlaces += $this->processOneDayForMemberReturnReservedPlaces($date, $member, $journal);

            $this->availablePlacesSummary -= $reservedPlaces;
            $this->availablePlacesByDate[$dateString] -= $reservedPlaces;
            if ($this->availablePlacesSummary < 0) {
                throw new \DomainException('Calculation error: availablePlacesSummary < 0');
            }
            if ($this->availablePlacesByDate[$dateString] < 0) {
                throw new \DomainException('Calculation error: availablePlacesByDate[date] < 0');
            }
        }

        $systemMember = $this->parkingReservationRepository->getSystemMember();
        $journalMove = new JournalMove(
            $journal,
            $systemMember,
            $date,
            0,
            $reservedPlaces * ApplicationEnum::PLACE_POINTS
        );
        $this->entitiesToSave[] = $journalMove;
    }

    private function processOneDayForMemberReturnReservedPlaces(\DateTimeImmutable $date, Member $member, Journal $journal): int
    {
        $dateString = $date->format(ApplicationEnum::DATE_FORMAT);

        if (false === $this->properties->isMembershipForMemberAndDate($member, $date)) {
            return 0;
        }

        if ($this->properties->getReservationForMemberAndDate($member, $date)) {
            return 0;
        }

        $places = 1;
        $memberNeed = $this->properties->getMemberNeedForMemberAndDate($member, $date);
        if ($memberNeed) {
            $places = $memberNeed->getPlaces();
        }
        if (0 === $places) {
            return 0;
        }
        if ($places > $this->availablePlacesByDate[$dateString]) {
            $places = $this->availablePlacesByDate[$dateString];
        }

        $reservation = new Reservation(
            $member,
            $date,
            $places,
            ReservationTypeEnum::ASSIGNED()
        );
        $this->entitiesToSave[] = $reservation;

        $journalMove = new JournalMove(
            $journal,
            $member,
            $date,
            $places * ApplicationEnum::PLACE_POINTS,
            0
        );
        $this->entitiesToSave[] = $journalMove;

        return $places;
    }
}
