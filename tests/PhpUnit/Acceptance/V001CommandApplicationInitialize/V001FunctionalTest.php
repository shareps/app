<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V001CommandApplicationInitialize;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V001FunctionalTest extends AcceptanceTestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::recreateDatabase();
        self::truncateDatabase(self::$entityManager);
    }

    public function test_initializeFirstTime(): void
    {
        $outputString = $this->executeCommandApplicationInitialize(self::$application);

        $this->assertContains('- Command    : ' . $this->commandName, $outputString);
        $this->assertContains('- Environment: test', $outputString);
    }

    public function test_initializeSecondTime(): void
    {
        $this->expectException(\OverflowException::class);
        $this->expectExceptionMessage('Already Initialized');

        $this->executeCommandApplicationInitialize(self::$application);
    }

    public function test_initializeSecondTimeDifferentEmail(): void
    {
        $this->expectException(\OverflowException::class);
        $this->expectExceptionMessage('Already Initialized');

        $this->executeCommandApplicationInitialize(self::$application, ['--email' => 'another@localhost.local']);
    }
}
