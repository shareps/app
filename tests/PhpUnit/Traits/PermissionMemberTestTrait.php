<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Functional\RoleEnum;
use App\Repository\Entity\Account\UserRepository;
use App\Repository\Entity\Parking\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @mixin TestCase
 */
trait PermissionMemberTestTrait
{
    protected function addPermissionMembers(ContainerInterface $container, array $fixturesData): void
    {
        /** @var MemberRepository $memberRepository */
        $memberRepository = $container->get(MemberRepository::class);
        foreach ($fixturesData['permissionMembers'] as $permissionMember) {
            $user = new User();
            $user->setEmail($permissionMember['email']);
            $member = new Member(
                $permissionMember['name'],
                new RoleEnum($permissionMember['role']),
                $user
            );

            $memberRepository->saveAllInTransaction($user, $member);
        }
    }

    protected function addPermissionMember(ContainerInterface $container, RoleEnum $roleEnum): Member
    {
        $uid = uniqid($roleEnum->getValue(), false);
        $user = new User();
        $user->setEmail(sprintf('%s@localhost.local', $uid));
        $member = new Member(
            $uid,
            $roleEnum,
            $user
        );
        /** @var MemberRepository $memberRepository */
        $memberRepository = $container->get(MemberRepository::class);
        $memberRepository->saveAllInTransaction($user, $member);

        return $member;
    }

    public function getPermissionMemberByEmail(EntityManagerInterface $entityManager, string $email): Member
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        return $user->getMember();
    }

    protected function assertAddPermissionMembers(ContainerInterface $container, array $fixturesData): void
    {
        $this->addPermissionMembers($container, $fixturesData);

        /** @var UserRepository $userRepository */
        $userRepository = $container->get(UserRepository::class);
        foreach (RoleEnum::toArray() as $role) {
            $this->assertArrayHasKey($role, $fixturesData['permissionMembers']);
            $this->assertCount(
                1,
                $userRepository->findBy(['email' => $fixturesData['permissionMembers'][$role]['email']])
            );
        }
    }
}
