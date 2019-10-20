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
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="parking_memberships")
 * @OA\ApiResource(
 *   normalizationContext={"groups"={"get"}},
 *   itemOperations={
 *     "get"
 *   },
 *   collectionOperations={
 *     "get"
 *   }
 * )
 */
class Membership implements EntityInterface, GetMemberInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="from_date", type="date_immutable", nullable=false)
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
    private $fromDate;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="to_date", type="date_immutable", nullable=false)
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
    private $toDate;

    //-------------------------------------------------------------------------------------------

    /**
     * @var Member
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member", inversedBy="memberships")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     *
     * @Assert\NotNull()
     *
     * @Serializer\Groups({"get"})
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
    private $member;

    //-------------------------------------------------------------------------------------------

    public function __construct(
        Member $member,
        \DateTimeImmutable $fromDate,
        \DateTimeImmutable $toDate
    ) {
        $this->id = ShortUuid::uuid4();
        $this->member = $member;
        $this->setFromDate($fromDate);
        $this->setToDate($toDate);
    }

    //-------------------------------------------------------------------------------------------

    public function getFromDate(): ?\DateTimeImmutable
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeImmutable $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeImmutable
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeImmutable $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getMember(): Member
    {
        return $this->member;
    }
}
