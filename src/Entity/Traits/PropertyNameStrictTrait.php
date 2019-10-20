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

trait PropertyNameStrictTrait
{
    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @OA\ApiProperty(
     *    attributes={
     *        "swagger_context"={
     *            "example"="Test Name"
     *        }
     *     }
     * )
     * @Gedmo\Versioned
     * @OA\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class, strategy="partial")
     * @SA\Groups({"read", "write"})
     */
    private $name = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }
}
