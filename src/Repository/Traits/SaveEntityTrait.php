<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Repository\Traits;

use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

trait SaveEntityTrait
{
    public function saveAllInTransaction(EntityInterface ...$entities): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getEntityManager();
        $entityManager->getConnection()->beginTransaction();
        try {
            foreach ($entities as $entity) {
                $entityManager->persist($entity);
            }
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Throwable $e) {
            $entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function saveAll(EntityInterface ...$entities): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getEntityManager();
        foreach ($entities as $entity) {
            $entityManager->persist($entity);
        }
        $entityManager->flush();
    }

    public function deleteAll(EntityInterface ...$entities): void
    {
        /** @var EntityManagerInterface $entityManager */
        $entityManager = $this->getEntityManager();
        foreach ($entities as $entity) {
            $entityManager->remove($entity);
        }
        $entityManager->flush();
    }
}
