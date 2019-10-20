<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Api\Dto\Parking;

use ApiPlatform\Core\Annotation as OA;
use App\Entity\Parking\Member;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class ReservationInputDto
{
    /**
     * @var \DateTimeImmutable
     *
     * @Assert\Date()
     *
     * @Serializer\Groups({"post"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="date", "example"="2000-01-01"},
     *         "normalization_context"={"date_format"="Y-m-d", "datetime_format"="Y-m-d"},
     *     }
     * )
     */
    public $date;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Enum\Entity\ReservationTypeEnum", "toArray"})
     * @Assert\Length(min="1", max="50")
     *
     * @Serializer\Groups({"post", "put"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "enum"={"REVOKED","ASSIGNED"}, "example"="REVOKED"},
     *     }
     * )
     */
    public $type;

    /**
     * @var int
     *
     * @Assert\PositiveOrZero()
     *
     * @Serializer\Groups({"post", "put"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="integer", "example"=0},
     *     }
     * )
     */
    public $places;

    //-------------------------------------------------------------------------------------------

    /**
     * @var Member
     *
     * @Assert\NotNull()
     *
     * @Serializer\Groups({"post"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "example"="id"},
     *     }
     * )
     */
    public $member;
}
