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

trait PropertyCodeStrictTrait
{
    /**
     * @var string Code, lowercase
     * @ORM\Column(name="code", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     * @OA\ApiProperty(
     *    attributes={
     *        "swagger_context"={
     *            "example"="CODE"
     *        }
     *     }
     * )
     * @Gedmo\Versioned
     * @OA\ApiFilter(ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class, strategy="partial")
     * @SA\Groups({"read"})
     */
    private $code = '';

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        if ('' !== $this->code) {
            throw new \OverflowException(sprintf('Code "%s" already set, can\'t be changed to "%s"!', $this->code, $code));
        }

        $this->code = strtoupper(trim($code));

        return $this;
    }
}
