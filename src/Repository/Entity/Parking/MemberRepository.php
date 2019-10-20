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
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.role = :role')
            ->andWhere('m.name = :name')
            ->setParameter('role', RoleEnum::SYSTEM)
            ->setParameter('name', ApplicationEnum::SYSTEM_MEMBER_NAME()->getValue())
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
