<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Functional;

use App\Entity\Parking\Availability;
use App\Entity\Parking\AvailabilityBreak;
use App\Entity\Parking\Member;
use App\Entity\Parking\MemberNeed;
use App\Entity\Parking\Reservation;
use App\Enum\Functional\ApplicationEnum;
use App\Repository\Traits\SaveEntityTrait;
use Doctrine\ORM\EntityManagerInterface;

class ParkingReservationRepository
{
    use SaveEntityTrait;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getSystemMember(): ?Member
    {
        return $this->entityManager
            ->getRepository(Member::class)
            ->getSystemMember();
    }

    public function getPlacesCountAvailableForDate(\DateTimeImmutable $date): int
    {
        $availablePlaces = 0;
        /** @var Availability|null $availability */
        $availability = $this->entityManager
            ->createQueryBuilder()
            ->select('a')
            ->from(Availability::class, 'a')
            ->where('a.fromDate <= :selectedDate')
            ->andWhere('a.toDate >= :selectedDate')
            ->setParameter('selectedDate', $date->format(ApplicationEnum::DATE_FORMAT))
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if ($availability) {
            $availablePlaces = $availability->getPlaces();
            /** @var AvailabilityBreak|null $availabilityBreak */
            $availabilityBreak = $this->entityManager
                ->createQueryBuilder()
                ->select('ab')
                ->from(AvailabilityBreak::class, 'ab')
                ->where('ab.date = :selectedDate')
                ->setParameter('selectedDate', $date->format(ApplicationEnum::DATE_FORMAT))
                ->getQuery()
                ->getOneOrNullResult()
            ;
            if ($availabilityBreak) {
                $availablePlaces = $availabilityBreak->getPlaces();
            }
        }

        return $availablePlaces;
    }

    /**
     * @return array|Member[]
     */
    public function getReservationsForDate(\DateTimeImmutable $date): array
    {
        /** @var Reservation[]|array $reservations */
        $reservations = $this->entityManager
            ->createQueryBuilder()
            ->select('r')
            ->from(Reservation::class, 'r')
            ->join('r.member', 'm')
            ->where('r.date = :selectedDate')
            ->setParameter('selectedDate', $date->format(ApplicationEnum::DATE_FORMAT))
            ->getQuery()
            ->getResult()
        ;

        return $reservations;
    }

    /**
     * @return array|Member[]
     */
    public function getMembersWithMembershipForDate(\DateTimeImmutable $date): array
    {
        /** @var Member[]|array $members */
        $members = $this->entityManager
            ->createQueryBuilder()
            ->select('m')
            ->from(Member::class, 'm')
            ->join('m.memberships', 'ms')
            ->where('ms.fromDate <= :selectedDate')
            ->andWhere('ms.toDate >= :selectedDate')
            ->setParameter('selectedDate', $date->format(ApplicationEnum::DATE_FORMAT))
            ->getQuery()
            ->getResult()
        ;

        return $members;
    }

    /**
     * @return array|Member[]
     */
    public function getMembersNeedsForDate(\DateTimeImmutable $date): array
    {
        /** @var MemberNeed[]|array $memberNeeds */
        $memberNeeds = $this->entityManager
            ->createQueryBuilder()
            ->select('mn, m')
            ->from(MemberNeed::class, 'mn')
            ->join('mn.member', 'm')
            ->where('mn.date <= :selectedDate')
            ->setParameter('selectedDate', $date->format(ApplicationEnum::DATE_FORMAT))
            ->getQuery()
            ->getResult()
        ;

        return $memberNeeds;
    }

    //------------------------------------------------------------------------------------------------------------------

    private function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
