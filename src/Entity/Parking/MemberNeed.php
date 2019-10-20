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
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Bridge\Doctrine\Validator\Constraints as OrmAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="parking_member_needs",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="parking_member_needs_date_member_uidx", columns={"date", "member_id"})}
 *     )
 * @OrmAssert\UniqueEntity(fields={"date", "member"}, errorPath="member", message="Date for Member already exist")
 * @OA\ApiResource(
 *   normalizationContext={"groups"={"get"}},
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_MEMBER_NEED_READ')"
 *     },
 *     "delete"={
 *       "access_control"="is_granted('PARKING_MEMBER_NEED_DELETE', object)"
 *     },
 *     "put"={
 *       "denormalization_context"={"groups"={"put"}},
 *       "access_control"="is_granted('PARKING_MEMBER_NEED_UPDATE', object) and is_granted('PARKING_MEMBER_NEED_UPDATE', previous_object)"
 *     }
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_MEMBER_NEED_READ')"
 *     },
 *     "post"={
 *       "denormalization_context"={"groups"={"post"}},
 *       "access_control"="is_granted('PARKING_MEMBER_NEED_CREATE', object)"
 *     }
 *   }
 * )
 */
class MemberNeed implements EntityInterface, GetMemberInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="date", type="date_immutable", nullable=false)
     *
     * @Assert\Date()
     *
     * @Serializer\Groups({"get", "put", "post"})
     * @@OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "format"="date_immutable", "example"="2000-01-01"},
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
     * @var int
     * @ORM\Column(name="places", type="integer", nullable=false)
     *
     * @Assert\PositiveOrZero()
     *
     * @Serializer\Groups({"get"})
     * @@OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="integer", "example"=0},
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

    /**
     * @var string
     * @ORM\Column(name="reason", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     *
     * @Serializer\Groups({"get", "put", "post"})
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="partial"
     * )
     */
    private $reason;

    //-------------------------------------------------------------------------------------------

    /**
     * @var Member
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member", inversedBy="memberNeeds")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     *
     * @Assert\NotNull()
     *
     * @Serializer\Groups({"get", "post"})
     * @OA\ApiProperty()
     * @OA\ApiSubresource(maxDepth=1)
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

    public function __construct(
        Member $member,
        int $places,
        string $reason,
        \DateTimeImmutable $date
    ) {
        $this->id = ShortUuid::uuid4();
        $this->member = $member;
        $this->places = $places;
        $this->setReason($reason);
        $this->setDate($date);
    }

    //-------------------------------------------------------------------------------------------

    public function getMember(): Member
    {
        return $this->member;
    }

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }
}
