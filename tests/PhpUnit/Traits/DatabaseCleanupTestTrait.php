<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use App\Entity;
use App\Repository\Entity\Account\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * @mixin TestCase
 */
trait DatabaseCleanupTestTrait
{
    protected static function recreateDatabase(): void
    {
        exec('php bin/console doctrine:schema:drop --env=test --force --full-database');
        exec('php bin/console doctrine:migrations:migrate --env=test --no-interaction');
    }

    protected static function truncateTable(EntityManagerInterface $entityManager, string $entityName): void
    {
        $entityManager->createQueryBuilder()->delete($entityName, 'd')->getQuery()->execute();
    }

    protected static function truncateDatabase(EntityManagerInterface $entityManager): void
    {
        self::truncateTable(self::$entityManager, Entity\System\RequestLogDetail::class);
        self::truncateTable(self::$entityManager, Entity\System\RequestLog::class);
        self::truncateTable(self::$entityManager, Entity\Accounting\JournalMove::class);
        self::truncateTable(self::$entityManager, Entity\Accounting\Journal::class);
        self::truncateTable(self::$entityManager, Entity\Accounting\Task::class);
        self::truncateTable(self::$entityManager, Entity\Parking\AvailabilityBreak::class);
        self::truncateTable(self::$entityManager, Entity\Parking\Availability::class);
        self::truncateTable(self::$entityManager, Entity\Parking\Reservation::class);
        self::truncateTable(self::$entityManager, Entity\Parking\Membership::class);
        self::truncateTable(self::$entityManager, Entity\Parking\MemberNeed::class);
        self::truncateTable(self::$entityManager, Entity\Parking\Member::class);
        self::truncateTable(self::$entityManager, Entity\Access\SlackIdentity::class);
        self::truncateTable(self::$entityManager, Entity\Access\GoogleIdentity::class);
        self::truncateTable(self::$entityManager, Entity\Access\User::class);
    }

    public function assertTruncateDatabase(EntityManagerInterface $entityManager): void
    {
        /** @var UserRepository $userRepository */
        $userRepository = $entityManager->getRepository(Entity\Access\User::class);
        self::truncateDatabase(self::$entityManager);
        $this->assertFalse($userRepository->isAny());
    }
}
