<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @mixin TestCase
 */
trait CommandApplicationInitializeTestTrait
{
    protected $commandName = 'app:application:initialize';

    protected function executeCommandApplicationInitialize(Application $application, array $changedArguments = []): string
    {
        $command = $application->find($this->commandName);
        $arguments = [
            'command' => $command->getName(),
            '--name' => 'ManagerAccountInitialize',
            '--email' => $_ENV['APPLICATION_INITIALIZE_EMAIL'],
            '--env' => 'test',
            '--run' => 1,
        ];
        $arguments = array_merge($arguments, $changedArguments);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments);

        return $commandTester->getDisplay();
    }

    protected function assertExecuteCommandApplicationInitialize(Application $application): void
    {
        $outputString = $this->executeCommandApplicationInitialize($application);

        $this->assertContains('- Command    : ' . $this->commandName, $outputString);
        $this->assertContains('- Environment: test', $outputString);
    }
}
