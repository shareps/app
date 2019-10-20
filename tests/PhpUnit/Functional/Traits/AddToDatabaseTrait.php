<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Functional\Traits;

use App\Entity\Parking\Availability;
use App\Entity\Parking\AvailabilityBreak;
use App\Entity\Parking\Member;
use App\Entity\Parking\Membership;
use App\Enum\Functional\RoleEnum;
use Doctrine\ORM\EntityManagerInterface;

trait AddToDatabaseTrait
{
    private static function addParkingAvailability(EntityManagerInterface $entityManager, int $places, string $fromDateString, string $toDateString): Availability
    {
        $availability = new Availability($places, new \DateTimeImmutable($fromDateString), new \DateTimeImmutable($toDateString));
        $entityManager->persist($availability);
        $entityManager->flush();

        return $availability;
    }

    private static function addParkingAvailabilityBreak(EntityManagerInterface $entityManager, int $places, string $dateString): AvailabilityBreak
    {
        $date = new \DateTimeImmutable($dateString);
        $availabilityBreak = new AvailabilityBreak($places, 'test', $date);
        $entityManager->persist($availabilityBreak);
        $entityManager->flush();

        return $availabilityBreak;
    }

    private static function addMember(EntityManagerInterface $entityManager, string $name): Member
    {
        $member = new Member($name, RoleEnum::MEMBER(), null);
        $entityManager->persist($member);
        $entityManager->flush();

        return $member;
    }

    private static function addMembership(EntityManagerInterface $entityManager, Member $member, string $fromDateString, string $toDateString): Membership
    {
        $membership = new Membership($member, new \DateTimeImmutable($fromDateString), new \DateTimeImmutable($toDateString));
        $entityManager->persist($membership);
        $entityManager->flush();

        return $membership;
    }
}
