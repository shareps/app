<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Parking;

use ApiPlatform\Core\Annotation as OA;
use App\Entity\Access\User;
use App\Entity\EntityInterface;
use App\Entity\GetRoleInterface;
use App\Entity\Traits;
use App\Enum\Functional\RoleEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Bridge\Doctrine\Validator\Constraints as OrmAssert;
use Symfony\Component\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Entity\Parking\MemberRepository")
 * @ORM\Table(name="parking_members")
 * @OrmAssert\UniqueEntity(fields={"name"}, errorPath="name", message="Name already exist")
 * @OrmAssert\UniqueEntity(fields={"user"}, errorPath="user", message="User already exist")
 * @OA\ApiResource(
 *   input={"class"="\App\Api\Dto\Parking\MemberInputDto"},
 *   normalizationContext={"groups"={"get"}},
 *   itemOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_MEMBER_READ')"
 *     },
 *     "delete"={
 *       "controller"="\App\Controller\Api\Parking\MemberDeleteAction",
 *       "access_control"="is_granted('PARKING_MEMBER_DELETE', object)"
 *     },
 *     "put"={
 *       "denormalization_context"={"groups"={"put"}},
 *       "access_control"="is_granted('PARKING_MEMBER_UPDATE', object) and is_granted('PARKING_MEMBER_UPDATE', previous_object)"
 *     }
 *   },
 *   collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('PARKING_MEMBER_READ')"
 *     },
 *     "post"={
 *       "denormalization_context"={"groups"={"post"}},
 *       "access_control"="is_granted('PARKING_MEMBER_CREATE', object)"
 *     }
 *   }
 * )
 */
class Member implements EntityInterface, GetRoleInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "example"="John Doe"},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="partial"
     * )
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(name="points", type="integer", nullable=false)
     *
     * @Assert\PositiveOrZero()
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="integer", "example"="0"},
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
    private $points;

    /**
     * @var string
     * @ORM\Column(name="role", type="string", length=50, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Choice(callback={"App\Enum\Functional\RoleEnum", "toArray"})
     * @Assert\Length(min="1", max="50")
     *
     * @Serializer\Groups({"get"})
     * @OA\ApiProperty(
     *     attributes={
     *         "swagger_context"={"type"="string", "enum"={"ROLE_MEMBER", "ROLE_MANAGER"}, "example"="ROLE_MEMBER"},
     *     }
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     strategy="exact"
     * )
     */
    private $role;

    //-------------------------------------------------------------------------------------------

    /**
     * @var User|null
     * @ORM\OneToOne(targetEntity="App\Entity\Access\User", inversedBy="member", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, unique=true)
     */
    private $user;

    /**
     * @var ArrayCollection|Membership[]
     * @ORM\OneToMany(targetEntity="App\Entity\Parking\Membership", mappedBy="member")
     */
    private $memberships;

    /**
     * @var ArrayCollection|MemberNeed[]
     * @ORM\OneToMany(targetEntity="App\Entity\Parking\MemberNeed", mappedBy="member")
     *
     * @OA\ApiSubresource(maxDepth=1)
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::class,
     *     strategy="ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter::INCLUDE_NULL_BEFORE",
     *     properties={"memberNeeds.date"}
     * )
     * @OA\ApiFilter(
     *     ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter::class,
     *     properties={"memberNeeds.date"},
     *     strategy="exact"
     * )
     */
    private $memberNeeds;

    //-------------------------------------------------------------------------------------------

    public function __construct(string $name, RoleEnum $role, ?User $user)
    {
        $this->id = ShortUuid::uuid4();
        $this->user = $user;
        $this->setName($name);
        $this->setPoints(0);
        $this->setRole($role);
        $this->memberships = new ArrayCollection();
        $this->memberNeeds = new ArrayCollection();
    }

    //-------------------------------------------------------------------------------------------

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function addPoints(int $points): self
    {
        $this->points += $points;

        return $this;
    }

    public function getRole(): RoleEnum
    {
        return new RoleEnum($this->role);
    }

    public function setRole(RoleEnum $role): self
    {
        $this->role = $role->getValue();

        return $this;
    }

    /**
     * @return Membership[]|ArrayCollection
     */
    public function getMemberships(): ArrayCollection
    {
        return $this->memberships;
    }

    /**
     * @return MemberNeed[]|ArrayCollection
     */
    public function getMemberNeeds(): ArrayCollection
    {
        return $this->memberNeeds;
    }
}
