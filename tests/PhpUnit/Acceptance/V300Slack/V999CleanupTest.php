<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use App\Repository\Entity\Account\UserRepository;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V999CleanupTest extends AcceptanceTestCase
{
    public function test_cleanup(): void
    {
        $userRepository = self::$container->get(UserRepository::class);
        self::truncateDatabase(self::$entityManager);
        $this->assertFalse($userRepository->isAny());
    }
}
