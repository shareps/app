<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Entity\Account;

use App\Entity\Access\User;
use App\Repository\Traits\SaveEntityTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    use SaveEntityTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function isAny(): bool
    {
        return $this->countAll() > 0;
    }

    public function countAll(): int
    {
        return $this->count([]);
    }
}
