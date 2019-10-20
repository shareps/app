<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Parking;

use ApiPlatform\Core\Annotation as OA;
use App\Entity\EntityInterface;
use App\Entity\GetMemberInterface;
use App\Entity\Traits;
use App\Enum\Entity\ReservationTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Bridge\Doctrine\Validator\Constraints as OrmAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Entity\Parking\ReservationRepository")
 * @ORM\Table(
 *     name="parking_reservations",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="parking_reservations_date_member_uidx", columns={"date", "member_id"})}
 *     )
 * @OrmAssert\UniqueEntity(fields={"date", "member"}, errorPath="member", message="Date for Member already exist")
 * @OA\ApiResource(
 *   input={"class"="\App\Api\Dto\Parking\ReservationInputDto"},
 *   normalizationContext={"groups"={"get"}},
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_RESERVATION_READ')"
 *     },
 *     "delete"={
 *       "controller"="\App\Controller\Api\Parking\ReservationDeleteAction",
 *       "access_control"="is_granted('PARKING_RESERVATION_DELETE', object)"
 *     },
 *     "put"={
 *       "denormalization_context"={"groups"={"put"}},
 *       "access_control"="is_granted('PARKING_RESERVATION_UPDATE', object) and is_granted('PARKING_RESERVATION_UPDATE', previous_object)"
 *     }
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_RESERVATION_READ')"
 *     },
 *     "post"={
 *       "denormalization_context"={"groups"={"post"}},
 *       "access_control"="is_granted('PARKING_RESERVATION_CREATE', object)"
 *     }
 *   }
 * )
 */
class Reservation implements EntityInterface, GetMemberInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="date", type="date_immutable", nullable=false)
     *
     * @Assert\Date()
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="date", "example"="2000-01-01"},
     *         "normalization_context"={"date_format"="Y-m-d", "datetime_format"="Y-m-d"},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::class,
     *     strategy="ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::INCLUDE_NULL_BEFORE"
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     */
    private $date;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(min="1", max="50")
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "enum"={"REVOKED","ASSIGNED"}, "example"="REVOKED"},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     */
    private $type;

    /**
     * @var int
     * @ORM\Column(name="places", type="integer", nullable=false)
     *
     * @Assert\PositiveOrZero()
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="integer", "example"=1},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter::class
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     */
    private $places;

    //-------------------------------------------------------------------------------------------

    /**
     * @var Member
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     *
     * @Assert\NotNull()
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiSubresource()
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "example"="id"},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact",
     *     properties={"member.id"}
     * )
     */
    protected $member;

    //-------------------------------------------------------------------------------------------

    public function __construct(Member $member, \DateTimeImmutable $date, int $places, ReservationTypeEnum $type)
    {
        $this->id = ShortUuid::uuid4();
        $this->member = $member;
        $this->date = $date;
        $this->setPlaces($places);
        $this->setType($type);
    }

    //-------------------------------------------------------------------------------------------

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getType(): ReservationTypeEnum
    {
        return new ReservationTypeEnum($this->type);
    }

    public function setType(ReservationTypeEnum $type): self
    {
        $this->type = $type->getValue();

        return $this;
    }
}
