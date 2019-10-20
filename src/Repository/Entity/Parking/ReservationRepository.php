<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Entity\Parking;

use App\Entity\Parking\Reservation;
use App\Repository\Traits\SaveEntityTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ReservationRepository extends ServiceEntityRepository
{
    use SaveEntityTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }
}
