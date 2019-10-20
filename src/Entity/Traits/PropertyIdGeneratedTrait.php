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
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

trait PropertyIdGeneratedTrait
{
    /**
     * @var string|null
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(name="id", type="string", length=22)
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank()
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(identifier=true)
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     */
    private $id;

    public function getId(): string
    {
        return $this->id;
    }
}
