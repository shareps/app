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
use Symfony\Component\Validator\Constraints as Assert;

trait PropertyActiveStrictTrait
{
    /**
     * @var bool Is active. Default false.
     * @ORM\Column(name="active", type="boolean", nullable=false)
     * @Assert\NotNull()
     * @OA\ApiProperty(
     *    attributes={
     *        "swagger_context"={
     *            "example"=false
     *        }
     *     }
     * )
     * @Gedmo\Versioned
     * @OA\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter::class)
     * @SA\Groups({"read", "write"})
     */
    private $active = false;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
