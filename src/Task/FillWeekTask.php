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
use App\Enum\Entity\JournalTypeEnum;
use App\Enum\Entity\TaskTypeEnum;
use App\Enum\Functional\ApplicationEnum;

class FillWeekTask extends AbstractTask
{
    /** @var array|EntityInterface[] */
    private $entitiesToSave = [];

    // -----------------------------------------------------------------------------------------------------------------

    public function run(\DateTimeImmutable $weekAnyWorkdayDate): void
    {
        $this->entitiesToSave = [];
        $weekWorkdaysDates = $this->getWeekWorkdaysDates($weekAnyWorkdayDate);

        $this->processAllDays(...$weekWorkdaysDates);
        $this->parkingReservationRepository->saveAllInTransaction(...$this->entitiesToSave);
    }

    // -----------------------------------------------------------------------------------------------------------------

    private function processAllDays(\DateTimeImmutable ...$dates): void
    {
        $task = new Task(TaskTypeEnum::FILL());
        $this->parkingReservationRepository->saveAll($task);

        foreach ($dates as $date) {
            $this->processOneDay($date, $task);
        }
    }

    private function processOneDay(\DateTimeImmutable $date, Task $task): void
    {
        $placesCount = $this->parkingReservationRepository->getPlacesCountAvailableForDate($date);
        $members = $this->parkingReservationRepository->getMembersWithMembershipForDate($date);
        $membersCount = \count($members);

        if (0 === $placesCount || 0 === $membersCount) {
            return;
        }

        $parkingPointsAvailable = $placesCount * ApplicationEnum::PLACE_POINTS;
        $pointsPerMember = (int) ceil($parkingPointsAvailable / $membersCount);
        $parkingPointsNormalized = $pointsPerMember * $membersCount;

        $journal = new Journal($task, JournalTypeEnum::FILL());
        $this->entitiesToSave[] = $journal;

        $systemMember = $this->parkingReservationRepository->getSystemMember();
        $journalMove = new JournalMove($journal, $systemMember, $date, $parkingPointsNormalized, 0);
        $this->entitiesToSave[] = $journalMove;

        foreach ($members as $member) {
            $this->processOneDayForMember($date, $member, $pointsPerMember, $journal);
        }
    }

    private function processOneDayForMember(
        \DateTimeImmutable $date,
        Member $member,
        int $pointsPerMember,
        Journal $journal
    ): void {
        $member->addPoints($pointsPerMember);
        $this->entitiesToSave[] = $member;

        $journalMove = new JournalMove($journal, $member, $date, 0, $pointsPerMember);
        $this->entitiesToSave[] = $journalMove;
    }
}
