<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Service\Parking;

use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Functional\PermissionEnum;
use App\Enum\Functional\RoleEnum;
use App\Repository\Entity\Parking\MemberRepository;
use App\Traits\AssertTrait;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MemberService
{
    use AssertTrait;

    /** @var MemberRepository */
    private $memberRepository;
    /** @var ValidatorInterface */
    private $validator;
    /** @var Security */
    private $security;

    public function __construct(MemberRepository $memberRepository, ValidatorInterface $validator, Security $security)
    {
        $this->memberRepository = $memberRepository;
        $this->validator = $validator;
        $this->security = $security;
    }

    public function updateMember(
        Member $member,
        string $name,
        RoleEnum $memberRoleEnum
    ): Member {
        $member->setName($name);
        $member->setRole($memberRoleEnum);
        $this->assertIsValidObject($this->validator, $member, null, ['put']);
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_MEMBER_UPDATE, $member);

        $this->memberRepository->saveAll($member);

        return $member;
    }

    public function createMember(
        string $name,
        string $email,
        RoleEnum $memberRoleEnum
    ): Member {
        $user = new User();
        $user->setEmail($email);
        $this->assertIsValidObject($this->validator, $user);
        $member = new Member(
            $name,
            $memberRoleEnum,
            $user
        );
        $this->assertIsValidObject($this->validator, $member);
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_MEMBER_CREATE, $member);

        $this->memberRepository->saveAllInTransaction($user, $member);

        return $member;
    }

    public function deleteMember(
        Member $member
    ): Member {
        $this->assertIsGranted($this->security, PermissionEnum::PARKING_MEMBER_DELETE, $member);

        $this->memberRepository->deleteAll($member);

        return $member;
    }
}
