<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Traits;

use ApiPlatform\Core\Annotation as OA;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as SA;

trait PropertyUpdatedAtRequiredTrait
{
    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(name="updated_at", type="datetime_immutable", nullable=false)
     * @Gedmo\Versioned
     * @Gedmo\Timestampable(on="update")
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::class,
     *     strategy="ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::INCLUDE_NULL_BEFORE"
     * )
     * @SA\Groups({"read"})
     */
    private $updatedAt;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
