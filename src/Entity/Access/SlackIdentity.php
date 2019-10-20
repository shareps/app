<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Access;

use App\Entity\EntityInterface;
use App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Bridge\Doctrine\Validator\Constraints as OrmAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="access_slack_identities")
 * @OrmAssert\UniqueEntity(fields={"slack_id"}, errorPath="slack_id", message="Slack ID already exist")
 * @OrmAssert\UniqueEntity(fields={"email"}, errorPath="email", message="Email already exist")
 * @OrmAssert\UniqueEntity(fields={"user"}, errorPath="user", message="User already exist")
 */
class SlackIdentity implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string
     * @ORM\Column(name="slack_id", type="string", length=16, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="16")
     */
    private $slackId;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min="1", max="255")
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="team_id", type="string", length=16, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="16")
     */
    private $teamId;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $name;

    /**
     * @var bool
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $isDeleted;

    /**
     * @var string
     * @ORM\Column(name="color", type="string", length=6, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="6")
     */
    private $color;

    /**
     * @var string
     * @ORM\Column(name="real_name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $realName;

    /**
     * @var string
     * @ORM\Column(name="tz", type="string", length=63, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="63")
     */
    private $tz;

    /**
     * @var string
     * @ORM\Column(name="tz_label", type="string", length=63, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="63")
     */
    private $tzLabel;

    /**
     * @var int
     * @ORM\Column(name="tz_offset", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $tzOffset;

    /**
     * @var bool
     * @ORM\Column(name="is_admin", type="boolean", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $isAdmin;

    /**
     * @var bool
     * @ORM\Column(name="is_bot", type="boolean", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $isBot;

    /**
     * @var int
     * @ORM\Column(name="updated", type="integer", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $updated;

    /**
     * @var bool
     * @ORM\Column(name="is_app_user", type="boolean", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $isAppUser;

    //-------------------------------------------------------------------------------------------

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\Access\User", inversedBy="googleIdentity", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $user;

    //-------------------------------------------------------------------------------------------

    public function __construct(User $user, string $slackId, string $email)
    {
        $this->id = ShortUuid::uuid4();
        $this->slackId = $slackId;
        $this->email = $email;
        $this->user = $user;
    }

    //-------------------------------------------------------------------------------------------

    public function getSlackId(): string
    {
        return $this->slackId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getTeamId(): string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getRealName(): string
    {
        return $this->realName;
    }

    public function setRealName(string $realName): self
    {
        $this->realName = $realName;

        return $this;
    }

    public function getTz(): string
    {
        return $this->tz;
    }

    public function setTz(string $tz): self
    {
        $this->tz = $tz;

        return $this;
    }

    public function getTzLabel(): string
    {
        return $this->tzLabel;
    }

    public function setTzLabel(string $tzLabel): self
    {
        $this->tzLabel = $tzLabel;

        return $this;
    }

    public function getTzOffset(): int
    {
        return $this->tzOffset;
    }

    public function setTzOffset(int $tzOffset): self
    {
        $this->tzOffset = $tzOffset;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function isBot(): bool
    {
        return $this->isBot;
    }

    public function setIsBot(bool $isBot): self
    {
        $this->isBot = $isBot;

        return $this;
    }

    public function getUpdated(): int
    {
        return $this->updated;
    }

    public function setUpdated(int $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function isAppUser(): bool
    {
        return $this->isAppUser;
    }

    public function setIsAppUser(bool $isAppUser): self
    {
        $this->isAppUser = $isAppUser;

        return $this;
    }
}
