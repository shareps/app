<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Functional;

use App\Entity\EntityInterface;
use App\Enum\Functional\ApplicationEnum;
use Doctrine\ORM\EntityManagerInterface;

class NotOverlappedDatesRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array|EntityInterface[]
     */
    public function getOverlappedEntities(
        string $entityClass,
        string $fromDateProperty,
        string $toDateProperty,
        \DateTimeInterface $fromDate,
        \DateTimeInterface $toDate
    ): array {
        $where = '(e._from >= :fromDate AND e._from <= :toDate) OR (:fromDate >= e._from AND :fromDate <= e._to)';
        $where = str_replace(['_from', '_to'], [$fromDateProperty, $toDateProperty], $where);

        return $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from($entityClass, 'e')
            ->where($where)
            ->setParameters([
                'fromDate' => $fromDate->format(ApplicationEnum::DATE_FORMAT),
                'toDate' => $toDate->format(ApplicationEnum::DATE_FORMAT),
            ])
            ->getQuery()
            ->getResult()
        ;
    }
}
