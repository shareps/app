<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Voter\Configuration;

use App\Entity\Access\User;
use App\Entity\GetMemberInterface;
use App\Entity\GetRoleInterface;
use App\Entity\Parking\Availability;
use App\Entity\Parking\AvailabilityBreak;
use App\Entity\Parking\Member;
use App\Entity\Parking\MemberNeed;
use App\Entity\Parking\Membership;
use App\Entity\Parking\Reservation;
use App\Enum\Functional\PermissionEnum;
use App\Service\Functional\ConfigurationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PermissionVoter extends Voter
{
    private const TYPE_BOOLEAN = 'TYPE_BOOLEAN';
    private const TYPE_ROLE = 'TYPE_ROLE';
    private const TYPE_MEMBER_ROLE = 'TYPE_MEMBER_ROLE';

    private $attributeMap = [
        PermissionEnum::PARKING_AVAILABILITY_CREATE => [self::TYPE_BOOLEAN, Availability::class, false],
        PermissionEnum::PARKING_AVAILABILITY_READ => [self::TYPE_BOOLEAN, Availability::class, true],
        PermissionEnum::PARKING_AVAILABILITY_UPDATE => [self::TYPE_BOOLEAN, Availability::class, false],
        PermissionEnum::PARKING_AVAILABILITY_DELETE => [self::TYPE_BOOLEAN, Availability::class, false],

        PermissionEnum::PARKING_AVAILABILITY_BREAK_CREATE => [self::TYPE_BOOLEAN, AvailabilityBreak::class, false],
        PermissionEnum::PARKING_AVAILABILITY_BREAK_READ => [self::TYPE_BOOLEAN, AvailabilityBreak::class, true],
        PermissionEnum::PARKING_AVAILABILITY_BREAK_UPDATE => [self::TYPE_BOOLEAN, AvailabilityBreak::class, false],
        PermissionEnum::PARKING_AVAILABILITY_BREAK_DELETE => [self::TYPE_BOOLEAN, AvailabilityBreak::class, false],

        PermissionEnum::PARKING_MEMBER_CREATE => [self::TYPE_ROLE, Member::class, false],
        PermissionEnum::PARKING_MEMBER_READ => [self::TYPE_BOOLEAN, Member::class, true],
        PermissionEnum::PARKING_MEMBER_UPDATE => [self::TYPE_ROLE, Member::class, false],
        PermissionEnum::PARKING_MEMBER_DELETE => [self::TYPE_ROLE, Member::class, false],

        PermissionEnum::PARKING_MEMBER_NEED_CREATE => [self::TYPE_MEMBER_ROLE, MemberNeed::class, false],
        PermissionEnum::PARKING_MEMBER_NEED_READ => [self::TYPE_BOOLEAN, MemberNeed::class, true],
        PermissionEnum::PARKING_MEMBER_NEED_UPDATE => [self::TYPE_MEMBER_ROLE, MemberNeed::class, false],
        PermissionEnum::PARKING_MEMBER_NEED_DELETE => [self::TYPE_MEMBER_ROLE, MemberNeed::class, false],

        PermissionEnum::PARKING_MEMBERSHIP_CREATE => [self::TYPE_MEMBER_ROLE, Membership::class, false],
        PermissionEnum::PARKING_MEMBERSHIP_READ => [self::TYPE_BOOLEAN, Membership::class, true],
        PermissionEnum::PARKING_MEMBERSHIP_UPDATE => [self::TYPE_MEMBER_ROLE, Membership::class, false],
        PermissionEnum::PARKING_MEMBERSHIP_DELETE => [self::TYPE_MEMBER_ROLE, Membership::class, false],

        PermissionEnum::PARKING_RESERVATION_CREATE => [self::TYPE_MEMBER_ROLE, Reservation::class, false],
        PermissionEnum::PARKING_RESERVATION_READ => [self::TYPE_BOOLEAN, Reservation::class, true],
        PermissionEnum::PARKING_RESERVATION_UPDATE => [self::TYPE_MEMBER_ROLE, Reservation::class, false],
        PermissionEnum::PARKING_RESERVATION_DELETE => [self::TYPE_MEMBER_ROLE, Reservation::class, false],
    ];

    /** @var ConfigurationService */
    private $configurationService;
    /** @var LoggerInterface */
    private $logger;

    //------------------------------------------------------------------------------------------------------------------

    public function __construct(ConfigurationService $configurationService, LoggerInterface $logger)
    {
        $this->configurationService = $configurationService;
        $this->logger = $logger;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * @param string       $attribute
     * @param object|mixed $subject
     */
    protected function supports($attribute, $subject): bool
    {
        $this->logger->debug(sprintf(
            'ConfigurationPermissionVoter Supports %s - %s',
            $attribute,
            $subject ? \get_class($subject) : 'null'
        ));
        if (!$this->isAttributeSupported($attribute)) {
            return false;
        }
        $configuration = $this->getAttributeConfiguration($attribute);

        if (null === $subject && $configuration->isNullable()) {
            return true;
        }

        $class = $configuration->getClass();
        if (!$subject instanceof $class) {
            return false;
        }

        return true;
    }

    /**
     * @param string|mixed $attribute
     * @param object|mixed $subject
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $this->assertAttributeAndSubject($attribute, $subject);
        $loggedInMember = $this->getLoggedInMember($token);
        if (!$loggedInMember instanceof Member) {
            return false;
        }
        $configuration = $this->getAttributeConfiguration($attribute);

        switch ($configuration->getType()) {
            case self::TYPE_BOOLEAN:
                $subjectRole = 'null';
                $isValid = $this->voteOnAttributeBoolean($attribute, $loggedInMember);
                break;
            case self::TYPE_ROLE:
                $this->assertSubjectHasRole($subject);
                /** @var GetRoleInterface $subject */
                $subjectRole = $subject->getRole()->getValue();
                $isValid = $this->voteOnAttributeRole($attribute, $subject, $loggedInMember);
                break;
            case self::TYPE_MEMBER_ROLE:
                $this->assertSubjectHasMember($subject);
                /** @var GetMemberInterface $subject */
                $subjectRole = $subject->getmember()->getRole()->getValue();
                $isValid = $this->voteOnAttributeMemberRole($attribute, $subject, $loggedInMember);
                break;
            default:
                throw new \LogicException('Unexpected type');
        }

        $this->logger->debug(sprintf(
            'ConfigurationPermissionVoter Result a:%s - c:%s - r:%s - sr:%s - v:%s',
            $attribute,
            $subject ? \get_class($subject) : 'null',
            $loggedInMember->getRole()->getValue(),
            $subjectRole,
            (int) $isValid
        ));

        return $isValid;
    }

    //------------------------------------------------------------------------------------------------------------------

    private function isAttributeSupported(string $attribute): bool
    {
        return \array_key_exists($attribute, $this->attributeMap);
    }

    private function getAttributeConfiguration(string $attribute): PermissionData
    {
        if ($this->isAttributeSupported($attribute)) {
            $configuration = $this->attributeMap[$attribute];

            return new PermissionData(...$configuration);
        }

        throw new \InvalidArgumentException('Attribute not supported');
    }

    private function getLoggedInMember(TokenInterface $token): ?Member
    {
        $loggedInUser = $token->getUser();
        if (!$loggedInUser instanceof User) {
            return null;
        }
        $loggedInMember = $loggedInUser->getMember();
        if (!$loggedInMember instanceof Member) {
            return null;
        }

        return $loggedInMember;
    }

    /**
     * @param string|mixed $attribute
     * @param object|mixed $subject
     */
    private function assertAttributeAndSubject($attribute, $subject): void
    {
        if (!$this->supports($attribute, $subject)) {
            throw new \LogicException('Invalid attribute or subject');
        }
    }

    protected function voteOnAttributeBoolean(string $attribute, Member $loggedInMember): bool
    {
        return $this->configurationService
            ->hasPermissionBoolean(
                new PermissionEnum($attribute),
                $loggedInMember->getRole()
            );
    }

    protected function voteOnAttributeRole(string $attribute, GetRoleInterface $subject, Member $loggedInMember): bool
    {
        $hasPermissionRole = $this->configurationService
            ->hasPermissionRole(
                new PermissionEnum($attribute),
                $loggedInMember->getRole(),
                $subject->getRole()
            );

        return $hasPermissionRole;
    }

    protected function voteOnAttributeMemberRole(string $attribute, GetMemberInterface $subject, Member $loggedInMember): bool
    {
        $hasPermissionRole = $this->configurationService
            ->hasPermissionRole(
                new PermissionEnum($attribute),
                $loggedInMember->getRole(),
                $subject->getMember()->getRole()
            );
        $hasPermissionSelfOnly = $this->configurationService
            ->hasPermissionSelfOnly(
                new PermissionEnum($attribute),
                $loggedInMember->getRole()
            );
        $hasSubjectOwnership = ($loggedInMember->getId() === $subject->getMember()->getId());

        return $hasPermissionRole || ($hasPermissionSelfOnly && $hasSubjectOwnership);
    }

    /**
     * @param object|mixed $subject
     */
    private function assertSubjectHasRole($subject): void
    {
        if (!$subject instanceof GetRoleInterface) {
            throw new \LogicException('Subject should implement GetRoleInterface');
        }
    }

    /**
     * @param object|mixed $subject
     */
    private function assertSubjectHasMember($subject): void
    {
        if (!$subject instanceof GetMemberInterface) {
            throw new \LogicException('Subject should implement GetMemberInterface');
        }
    }
}
