<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Task;

use App\Repository\Functional\ParkingReservationRepository;

abstract class AbstractTask implements TaskInterface
{
    /** @var ParkingReservationRepository */
    protected $parkingReservationRepository;

    // -----------------------------------------------------------------------------------------------------------------

    public function __construct(ParkingReservationRepository $parkingReservationRepository)
    {
        $this->parkingReservationRepository = $parkingReservationRepository;
    }

    // -----------------------------------------------------------------------------------------------------------------

    /**
     * @return array|\DateTimeImmutable[]
     */
    protected function getWeekWorkdaysDates(\DateTimeImmutable $weekWorkdayDate): array
    {
        $processedWeekFirstDay = $weekWorkdayDate->modify('Monday this week');

        return [
            $processedWeekFirstDay,
            $processedWeekFirstDay->modify('+1 day'),
            $processedWeekFirstDay->modify('+2 days'),
            $processedWeekFirstDay->modify('+3 days'),
            $processedWeekFirstDay->modify('+4 days'),
        ];
    }
}
