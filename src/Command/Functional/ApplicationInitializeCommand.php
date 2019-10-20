<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Command\Functional;

use App\Command\AbstractCommand;
use App\Enum\Functional\RoleEnum;
use App\Repository\Entity\Account\UserRepository;
use App\Service\Functional\ApplicationInitializeService;
use App\Service\Parking\MemberService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApplicationInitializeCommand extends AbstractCommand
{
    protected static $defaultName = 'app:application:initialize';
    /**
     * @var array
     */
    protected $environments = [self::ENV_TEST, self::ENV_PROD];
    /**
     * @var ApplicationInitializeService
     */
    private $applicationInitializeService;
    /**
     * @var MemberService
     */
    private $memberService;

    public function __construct(
        UserRepository $userRepository,
        TokenStorageInterface $tokenStorage,
        ApplicationInitializeService $applicationInitializeService,
        MemberService $memberService
    ) {
        parent::__construct($userRepository, $tokenStorage);
        $this->applicationInitializeService = $applicationInitializeService;
        $this->memberService = $memberService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Initialize application, creates first manager account.')
            ->setHelp('This command allows you to initialize a fresh account. Can be executed only once.');
        $this->addOption(
            'name',
            null,
            InputOption::VALUE_REQUIRED,
            'Name for Manager'
        )->addOption(
            'email',
            null,
            InputOption::VALUE_REQUIRED,
            'Email for Manager'
        );
        parent::configure();
    }

    protected function executeBody(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $name */
        $name = $input->getOption('name');
        /** @var string $email */
        $email = $input->getOption('email');

        $this->applicationInitializeService->createSystemMember();
        $this->logInAsSystemMember();
        $this->memberService->createMember(
            $name,
            $email,
            RoleEnum::MANAGER()
        );

        return self::CODE_SUCCESS;
    }
}
