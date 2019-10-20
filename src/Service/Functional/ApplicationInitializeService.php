<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Service\Functional;

use App\Entity\Access\User;
use App\Entity\Parking\Member;
use App\Enum\Functional\ApplicationEnum;
use App\Enum\Functional\RoleEnum;
use App\Repository\Entity\Account\UserRepository;
use App\Traits\AssertTrait;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApplicationInitializeService
{
    use AssertTrait;

    /** @var UserRepository */
    private $userRepository;
    /** @var ValidatorInterface */
    private $validator;

    public function __construct(UserRepository $userRepository, ValidatorInterface $validator)
    {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    public function createSystemMember(): Member
    {
        if ($this->userRepository->isAny()) {
            throw new \OverflowException('Already Initialized');
        }
        $user = new User();
        $user->setEmail(ApplicationEnum::SYSTEM_MEMBER_EMAIL);
        $this->assertIsValidObject($this->validator, $user);
        $member = new Member(
            ApplicationEnum::SYSTEM_MEMBER_NAME,
            RoleEnum::SYSTEM(),
            $user
        );
        $this->assertIsValidObject($this->validator, $member);

        $this->userRepository->saveAllInTransaction($user, $member);

        return $member;
    }
}
