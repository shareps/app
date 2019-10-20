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
 * @ORM\Table(name="access_google_identities")
 * @OrmAssert\UniqueEntity(fields={"google_id"}, errorPath="google_id", message="Gmail ID already exist")
 * @OrmAssert\UniqueEntity(fields={"email"}, errorPath="email", message="Email already exist")
 * @OrmAssert\UniqueEntity(fields={"user"}, errorPath="user", message="User already exist")
 */
class GoogleIdentity implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string
     * @ORM\Column(name="google_id", type="string", length=25, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="25")
     */
    private $googleId;

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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="given_name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $givenName;

    /**
     * @var string
     * @ORM\Column(name="family_name", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $familyName;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $picture;

    /**
     * @var string
     * @ORM\Column(name="locale", type="string", length=5, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Locale()
     * @Assert\Length(min="2", max="5")
     */
    private $locale;

    //-------------------------------------------------------------------------------------------

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\Access\User", inversedBy="googleIdentity", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $user;

    //-------------------------------------------------------------------------------------------

    public function __construct(User $user, string $googleId, string $email)
    {
        $this->id = ShortUuid::uuid4();
        $this->user = $user;
        $this->googleId = $googleId;
        $this->email = $email;
    }

    //-------------------------------------------------------------------------------------------

    public function getUser(): User
    {
        return $this->user;
    }

    public function getGoogleId(): string
    {
        return $this->googleId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName): self
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName): self
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
