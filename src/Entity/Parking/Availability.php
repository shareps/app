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
use App\Entity\Traits;
use App\Validator\Constraints\NotOverlappedDates;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="parking_availabilities")
 * @OA\ApiResource(
 *   normalizationContext={"groups"={"get"}},
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_AVAILABILITY_READ')"
 *     },
 *     "delete"={
 *       "controller"="\App\Controller\Api\Parking\AvailabilityDeleteAction",
 *       "access_control"="is_granted('PARKING_AVAILABILITY_DELETE', object)"
 *     },
 *     "put"={
 *       "denormalization_context"={"groups"={"put"}},
 *       "access_control"="is_granted('PARKING_AVAILABILITY_UPDATE', object) and is_granted('PARKING_AVAILABILITY_UPDATE', previous_object)"
 *     }
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_AVAILABILITY_READ')"
 *     },
 *     "post"={
 *       "denormalization_context"={"groups"={"post"}},
 *       "access_control"="is_granted('PARKING_AVAILABILITY_CREATE', object)"
 *     },
 *   }
 * )
 * @NotOverlappedDates(
 *     fromDateProperty="fromDate",
 *     fromDateMethod="getFromDate",
 *     toDateProperty="toDate",
 *     toDateMethod="getToDate",
 * )
 */
class Availability implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var int
     * @ORM\Column(name="places", type="integer", nullable=false)
     *
     * @Assert\PositiveOrZero()
     *
     * @Serializer\Groups({"get", "put", "post"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="integer", "example"=100},
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
     * @var \DateTimeImmutable
     * @ORM\Column(name="from_date", type="date_immutable", nullable=false)
     *
     * @Assert\Date()
     *
     * @Serializer\Groups({"get", "put", "post"})
     * @OA\ApiProperty(
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
    private $fromDate;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="to_date", type="date_immutable", nullable=false)
     *
     * @Assert\Date()
     * @Assert\GreaterThan(propertyPath="fromDate")
     *
     * @Serializer\Groups({"get", "put", "post"})
     * @OA\ApiProperty(
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
    private $toDate;

    //-------------------------------------------------------------------------------------------

    public function __construct(
        int $places,
        \DateTimeImmutable $fromDate,
        \DateTimeImmutable $toDate
    ) {
        $this->id = ShortUuid::uuid4();
        $this->places = $places;
        $this->setFromDate($fromDate);
        $this->setToDate($toDate);
    }

    //-------------------------------------------------------------------------------------------

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getFromDate(): \DateTimeImmutable
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeImmutable $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): \DateTimeImmutable
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeImmutable $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }
}
