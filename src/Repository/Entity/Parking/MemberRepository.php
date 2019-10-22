<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Entity\Parking;

use App\Entity\Parking\Member;
use App\Enum\Functional\ApplicationEnum;
use App\Enum\Functional\RoleEnum;
use App\Repository\Traits\SaveEntityTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class MemberRepository extends ServiceEntityRepository
{
    use SaveEntityTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Member::class);
    }

    public function getSystemMember(): ?Member
    {
        return $this->createQueryBuilder('member')
            ->select('member')
            ->where('member.role = :role')
            ->andWhere('member.name = :name')
            ->setParameter('role', RoleEnum::SYSTEM)
            ->setParameter('name', ApplicationEnum::SYSTEM_MEMBER_NAME()->getValue())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    public function findOneBySlackUserId(string $slackUserId): ?Member
    {
        return $this->createQueryBuilder('member')
            ->select('member')
            ->join('member.user', 'user')
            ->join('user.slackIdentity', 'slack')
            ->where('slack.slackId = :slackUserId')
            ->setParameter('slackUserId', $slackUserId)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
