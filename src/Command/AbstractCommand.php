<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Command;

use App\Entity\Access\User;
use App\Enum\Functional\ApplicationEnum;
use App\Repository\Entity\Account\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

abstract class AbstractCommand extends Command
{
    protected const CODE_SUCCESS = 0;
    protected const CODE_ERROR = 1;
    protected const ENV_PROD = 'prod';
    protected const ENV_DEV = 'dev';
    protected const ENV_TEST = 'test';
    protected const OPTION_RUN = 'run';
    protected const LINE_SEPARATOR = '-------------------------------------------------------------';
    protected $environments = [];
    /** @var UserRepository */
    private $userRepository;
    /** @var TokenStorageInterface */
    private $tokenStorage;

    //------------------------------------------------------------------------------------------------------------------

    public function __construct(UserRepository $userRepository, TokenStorageInterface $tokenStorage)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->tokenStorage = $tokenStorage;
    }

    //------------------------------------------------------------------------------------------------------------------

    protected function configure(): void
    {
        $this->addOption(
            self::OPTION_RUN,
            null,
            InputOption::VALUE_REQUIRED,
            'Required to run command'
        );
    }

    abstract protected function executeBody(InputInterface $input, OutputInterface $output): int;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->checkEnvironmentName($input);
        $this->checkAllRequiredOptionsAreNotEmpty($input);
        $this->printHeader($input, $output);

        return $this->executeBody($input, $output);
    }

    protected function logInAsSystemMember(): void
    {
        /** @var User $user */
        $user = $this->userRepository
            ->findOneBy(
                [
                    'email' => ApplicationEnum::SYSTEM_MEMBER_EMAIL,
                ]
            );

        $token = new UsernamePasswordToken(
            $user,
            null,
            'main',
            $user->getRoles()
        );
        $this->tokenStorage->setToken($token);
    }

    //------------------------------------------------------------------------------------------------------------------

    private function checkAllRequiredOptionsAreNotEmpty(InputInterface $input): void
    {
        $options = $this->getDefinition()->getOptions();
        foreach ($options as $option) {
            $name = $option->getName();
            $value = $input->getOption($name);
            if (empty($value) && $option->isValueRequired()) {
                throw new \InvalidArgumentException(sprintf('The required value for option "%s" is not set', $name));
            }
        }
    }

    private function checkEnvironmentName(InputInterface $input): void
    {
        /** @var string $env */
        $env = $input->getOption('env');
        if (false === \in_array($env, $this->environments, true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Environment "%s" not supported, only ["%s"] allowed!',
                    $env,
                    implode('","', $this->environments)
                )
            );
        }
    }

    private function printHeader(InputInterface $input, OutputInterface $output): void
    {
        /** @var string $env */
        $env = $input->getOption('env');
        $output->writeln(self::LINE_SEPARATOR);
        $output->writeln('- Command    : ' . $this->getName());
        $output->writeln('- Environment: ' . $env);
        $output->writeln(self::LINE_SEPARATOR);
    }
}
