<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance;

use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Entity\ReservationTypeEnum;
use App\Enum\Functional\RoleEnum;
use App\Service\Functional\ConfigurationService;
use AppTests\PhpUnit\Traits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AcceptanceTestCase extends WebTestCase
{
    use Traits\ApiLogInTestTrait;
    use Traits\CommandApplicationInitializeTestTrait;
    use Traits\DatabaseCleanupTestTrait;
    use Traits\PermissionMemberTestTrait;
    use Traits\ApiAvailabilityTestTrait;
    use Traits\ApiAvailabilityBreakTestTrait;
    use Traits\ApiMemberTestTrait;
    use Traits\ApiMemberNeedTestTrait;
    use Traits\ApiReservationTestTrait;

    /** * @var Application */
    protected static $application;
    /** * @var EntityManagerInterface */
    protected static $entityManager;
    /** * @var KernelBrowser */
    protected static $client;
    /** * @var ConfigurationService */
    protected static $configurationService;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$application = new Application(self::$kernel);
        self::$entityManager = self::$container->get('doctrine.orm.default_entity_manager');
        self::$client = static::createClient([], ['HTTPS' => true]);
        self::$configurationService = self::$container->get(ConfigurationService::class);
    }

    protected function tearDown(): void
    {
        // purposefully not calling parent class, which shuts down the kernel
    }

    protected function jsonDecode(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function jsonEncode(array $data): string
    {
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    protected function apiLogInRole(string $role): User
    {
        $user = $this->getFixturePermissionUser($role);
        $this->apiLogInUser(self::$container, self::$client, $user);

        return $user;
    }

    protected function getFixturePermissionUser(string $role): User
    {
        /** @var User $user */
        $user = self::$entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $this->getFixturesData()['permissionMembers'][$role]['email']]);

        return $user;
    }

    protected function getFixturePermissionMember(string $role): Member
    {
        $user = $this->getFixturePermissionUser($role);

        return $user->getMember();
    }

    protected function getFixturesData(): array
    {
        return [
            'permissionMembers' => [
                RoleEnum::USER => [
                    'email' => 'ROLEUSER@localhost.local',
                    'name' => 'ROLE USER',
                    'role' => 'ROLE_USER',
                ],
                RoleEnum::DUMMY => [
                    'email' => 'ROLEDUMMY@localhost.local',
                    'name' => 'ROLE DUMMY',
                    'role' => 'ROLE_DUMMY',
                ],
                RoleEnum::MEMBER => [
                    'email' => 'ROLEMEMBER@localhost.local',
                    'name' => 'ROLE MEMBER',
                    'role' => 'ROLE_MEMBER',
                ],
                RoleEnum::MANAGER => [
                    'email' => 'ROLEMANAGER@localhost.local',
                    'name' => 'ROLE MANAGER',
                    'role' => 'ROLE_MANAGER',
                ],
                RoleEnum::SYSTEM => [
                    'email' => 'ROLESYSTEM@localhost.local',
                    'name' => 'ROLE SYSTEM',
                    'role' => 'ROLE_SYSTEM',
                ],
            ],
            'availabilities' => [
                [
                    'fromDateModifier' => '+0 weeks',
                    'toDateModifier' => '+4 weeks, -1 day',
                    'places' => 2,
                ],
                [
                    'fromDateModifier' => '+4 weeks',
                    'toDateModifier' => '+8 weeks, -1 day',
                    'places' => 3,
                ],
                [
                    'fromDateModifier' => '+8 weeks',
                    'toDateModifier' => '+10 weeks, -1 day',
                    'places' => 1,
                ],
            ],
            'availabilityBreaks' => [
                [
                    'dateModifier' => '+1 weeks, +1 day',
                    'places' => 0,
                ],
                [
                    'dateModifier' => '+2 weeks, +1 day',
                    'places' => 1,
                ],
                [
                    'dateModifier' => '+3 weeks, +1 day',
                    'places' => 2,
                ],
                [
                    'dateModifier' => '+4 weeks, +1 day',
                    'places' => 0,
                ],
                [
                    'dateModifier' => '+5 weeks, +1 day',
                    'places' => 1,
                ],
                [
                    'dateModifier' => '+6 weeks, +1 day',
                    'places' => 2,
                ],
                [
                    'dateModifier' => '+7 weeks, +1 day',
                    'places' => 3,
                ],
                [
                    'dateModifier' => '+8 weeks, +1 day',
                    'places' => 0,
                ],
                [
                    'dateModifier' => '+9 weeks, +1 day',
                    'places' => 1,
                ],
            ],
            'members' => [
                'mamberB1@localhost.local' => [
                    'email' => 'memberB1@localhost.local',
                    'name' => 'MemberB1',
                    'role' => 'ROLE_MEMBER',
                ],
                'mamberB2@localhost.local' => [
                    'email' => 'memberB2@localhost.local',
                    'name' => 'MemberB2',
                    'role' => 'ROLE_MEMBER',
                ],
                'mamberB4@localhost.local' => [
                    'email' => 'memberB4@localhost.local',
                    'name' => 'MemberB4',
                    'role' => 'ROLE_MEMBER',
                ],
                'mamberC1@localhost.local' => [
                    'email' => 'memberC1@localhost.local',
                    'name' => 'MemberC1',
                ],
                'mamberC2@localhost.local' => [
                    'email' => 'memberC2@localhost.local',
                    'name' => 'MemberC2',
                    'role' => 'ROLE_MEMBER',
                ],
                'mamberC3@localhost.local' => [
                    'email' => 'memberC3@localhost.local',
                    'name' => 'MemberC3',
                    'role' => 'ROLE_MEMBER',
                ],
                'mamberAnyRole@localhost.local' => [
                    'email' => 'memberAnyRole@localhost.local',
                    'name' => 'MemberAnyRole',
                    'role' => 'ROLE_MEMBER',
                ],
            ],
            'memberships' => [
                'memberB1@localhost.local' => [
                    [
                        'fromDateModifier' => '+1 week',
                        'toDateModifier' => '+2 weeks, -1 day',
                    ],
                    [
                        'fromDateModifier' => '+3 weeks',
                        'toDateModifier' => '+4 weeks, -1 day',
                    ],
                    [
                        'fromDateModifier' => '+5 weeks',
                        'toDateModifier' => '+6 weeks, -1 day',
                    ],
                    [
                        'fromDateModifier' => '+7 weeks',
                        'toDateModifier' => '+8 weeks, -1 day',
                    ],
                ],
                'memberB2@localhost.local' => [
                    [
                        'fromDateModifier' => '+2 weeks',
                        'toDateModifier' => '+4 weeks, -1 day',
                    ],
                    [
                        'fromDateModifier' => '+6 weeks',
                        'toDateModifier' => '+8 weeks, -1 day',
                    ],
                ],
                'memberB4@localhost.local' => [
                    [
                        'fromDateModifier' => '+4 weeks, -1 day',
                        'toDateModifier' => '+8 weeks, -1 day',
                    ],
                ],
                'memberC1@localhost.local' => [
                    [
                        'fromDateModifier' => '+8 weeks',
                        'toDateModifier' => '+8 weeks, +1 days',
                    ],
                    [
                        'fromDateModifier' => '+9 weeks',
                        'toDateModifier' => '+9 weeks, +1 days',
                    ],
                ],
                'memberC2@localhost.local' => [
                    [
                        'fromDateModifier' => '+8 weeks',
                        'toDateModifier' => '+8 weeks, +2 days',
                    ],
                    [
                        'fromDateModifier' => '+9 weeks, +1 days',
                        'toDateModifier' => '+9 weeks, +2 days',
                    ],
                ],
                'memberC3@localhost.local' => [
                    [
                        'fromDateModifier' => '+8 weeks',
                        'toDateModifier' => '+8 weeks, +3 days',
                    ],
                    [
                        'fromDateModifier' => '+9 weeks, +3 days',
                        'toDateModifier' => '+9 weeks, +3 days',
                    ],
                ],
            ],
            'memberNeeds' => [
                'member01@localhost.local' => [
                    [
                        'dateModifier' => '+8 weeks',
                        'places' => 0,
                    ],
                ],
            ],
            'reservations' => [
                'memberB1@localhost.local' => [
                    [
                        'dateModifier' => '+1 day',
                        'places' => 1,
                        'type' => ReservationTypeEnum::ASSIGNED,
                    ],
                ],
            ],
        ];
    }
}
