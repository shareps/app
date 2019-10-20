<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Functional\Repository\Functional;

use App\Entity\Parking\Member;
use App\Repository\Functional\ParkingReservationRepository;
use AppTests\PhpUnit\Functional\Traits\AddToDatabaseTrait;
use AppTests\PhpUnit\Traits\DatabaseCleanupTestTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ParkingReservationRepositoryTest extends KernelTestCase
{
    use DatabaseCleanupTestTrait;
    use AddToDatabaseTrait;

    /** @var ParkingReservationRepository|null */
    private static $repository;
    /** @var Application|null */
    private static $application;
    /** @var EntityManagerInterface|null */
    private static $entityManager;
    /** @var array|Member[] */
    private static $members = [];

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$application = new Application(self::$kernel);
        self::$entityManager = self::$container->get('doctrine.orm.default_entity_manager');
        self::$repository = new ParkingReservationRepository(self::$entityManager);
        self::truncateDatabase(self::$entityManager);
    }

    public static function tearDownAfterClass(): void
    {
        self::truncateDatabase(self::$entityManager);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function test_getPlacesCountAvailableForDate(): void
    {
        $this->assertPlacesCountForDate('-1 week', 0);
        $this->assertPlacesCountForDate('-1 day', 0);
        $this->assertPlacesCountForDate('now', 0);
        $this->assertPlacesCountForDate('+1 day', 0);
        $this->assertPlacesCountForDate('+1 week', 0);
        $this->assertPlacesCountForDate('+1 month', 0);

        //--------------------------------------------------------------------------------------------------------------

        self::addParkingAvailability(self::$entityManager, 1, '-14 days', '-5 days');
        self::addParkingAvailability(self::$entityManager, 2, '-4 days', '-3 days');
        self::addParkingAvailability(self::$entityManager, 3, '-2 days', '-1 days');
        self::addParkingAvailability(self::$entityManager, 4, 'now', '+1 day');
        self::addParkingAvailability(self::$entityManager, 5, '+2 days', '+4 days');
        self::addParkingAvailability(self::$entityManager, 6, '+5 days', '+14 days');

        $this->assertPlacesCountForDate('-1 week', 1);
        $this->assertPlacesCountForDate('-1 day', 3);
        $this->assertPlacesCountForDate('now', 4);
        $this->assertPlacesCountForDate('+1 day', 4);
        $this->assertPlacesCountForDate('+1 week', 6);
        $this->assertPlacesCountForDate('+1 month', 0);

        //--------------------------------------------------------------------------------------------------------------

        self::addParkingAvailabilityBreak(self::$entityManager, 7, '-1 day');
        self::addParkingAvailabilityBreak(self::$entityManager, 8, 'now');
        self::addParkingAvailabilityBreak(self::$entityManager, 9, '+1 day');

        $this->assertPlacesCountForDate('-1 week', 1);
        $this->assertPlacesCountForDate('-1 day', 7);
        $this->assertPlacesCountForDate('now', 8);
        $this->assertPlacesCountForDate('+1 day', 9);
        $this->assertPlacesCountForDate('+1 week', 6);
        $this->assertPlacesCountForDate('+1 month', 0);

        //--------------------------------------------------------------------------------------------------------------

        self::addParkingAvailabilityBreak(self::$entityManager, 10, '+1 month');
        $this->assertPlacesCountForDate('+1 month', 0);
    }

    public function test_getMembersWithMembershipForDate(): void
    {
        $this->assertMembersCountForDate('-1 week', 0);
        $this->assertMembersCountForDate('-1 day', 0);
        $this->assertMembersCountForDate('now', 0);
        $this->assertMembersCountForDate('+1 day', 0);
        $this->assertMembersCountForDate('+1 week', 0);
        $this->assertMembersCountForDate('+1 month', 0);

        //--------------------------------------------------------------------------------------------------------------

        $members = [];
        $members[1] = self::addMember(self::$entityManager, 'Member01');
        $members[2] = self::addMember(self::$entityManager, 'Member02');
        $members[3] = self::addMember(self::$entityManager, 'Member03');
        $members[4] = self::addMember(self::$entityManager, 'Member04');
        $members[5] = self::addMember(self::$entityManager, 'Member05');
        $members[6] = self::addMember(self::$entityManager, 'Member06');
        $members[7] = self::addMember(self::$entityManager, 'Member07');

        self::addMembership(self::$entityManager, $members[1], '-14 days', '+14 days');
        self::addMembership(self::$entityManager, $members[2], '-4 days', '+14 days');
        self::addMembership(self::$entityManager, $members[3], '-2 days', '+14 days');
        self::addMembership(self::$entityManager, $members[4], 'now', '+14 days');
        self::addMembership(self::$entityManager, $members[5], '+2 days', '+14 days');
        self::addMembership(self::$entityManager, $members[6], '+5 days', '+14 days');

        $this->assertMembersCountForDate('-1 week', 1);
        $this->assertMembersCountForDate('-1 day', 3);
        $this->assertMembersCountForDate('now', 4);
        $this->assertMembersCountForDate('+1 day', 4);
        $this->assertMembersCountForDate('+1 week', 6);
        $this->assertMembersCountForDate('+1 month', 0);

        //--------------------------------------------------------------------------------------------------------------

        self::addMembership(self::$entityManager, $members[7], 'now', '+14 days');

        $this->assertMembersCountForDate('-1 week', 1);
        $this->assertMembersCountForDate('-1 day', 3);
        $this->assertMembersCountForDate('now', 5);
        $this->assertMembersCountForDate('+1 day', 5);
        $this->assertMembersCountForDate('+1 week', 7);
        $this->assertMembersCountForDate('+1 month', 0);
    }

    //------------------------------------------------------------------------------------------------------------------

    private function assertPlacesCountForDate(string $dateString, int $placesExpected): void
    {
        $date = new \DateTimeImmutable($dateString);
        $placesCount = self::$repository->getPlacesCountAvailableForDate($date);

        $this->assertSame($placesExpected, $placesCount);
    }

    private function assertMembersCountForDate(string $dateString, int $membersExpected): void
    {
        $date = new \DateTimeImmutable($dateString);
        $members = self::$repository->getMembersWithMembershipForDate($date);

        $this->assertSame($membersExpected, \count($members));
    }
}
