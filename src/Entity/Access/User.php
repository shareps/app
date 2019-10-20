<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\Access;

use App\Entity\EntityInterface;
use App\Entity\Parking\Member;
use App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Bridge\Doctrine\Validator\Constraints as OrmAssert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Entity\Account\UserRepository")
 * @ORM\Table(name="access_users")
 * @OrmAssert\UniqueEntity(fields={"email"}, errorPath="email", message="Email already exist")
 * @OrmAssert\UniqueEntity(fields={"member"}, errorPath="member", message="Member already exist")
 */
class User implements UserInterface, EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string|null
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min="1", max="255")
     */
    private $email;

    //-------------------------------------------------------------------------------------------

    /**
     * @var GoogleIdentity|null
     * @ORM\OneToOne(targetEntity="App\Entity\Access\GoogleIdentity", mappedBy="user", cascade={"persist"})
     */
    private $googleIdentity;

    /**
     * @var SlackIdentity|null
     * @ORM\OneToOne(targetEntity="App\Entity\Access\SlackIdentity", mappedBy="user", cascade={"persist"})
     */
    private $slackIdentity;

    /**
     * @var Member|null
     * @ORM\OneToOne(targetEntity="App\Entity\Parking\Member", mappedBy="user", cascade={"persist"})
     */
    private $member;

    //-------------------------------------------------------------------------------------------

    public function __construct()
    {
        $this->id = ShortUuid::uuid4();
    }

    //-------------------------------------------------------------------------------------------

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = trim($email);

        return $this;
    }

    //-------------------------------------------------------------------------------------------

    public function getGoogleIdentity(): ?GoogleIdentity
    {
        return $this->googleIdentity;
    }

    public function setGoogleIdentity(GoogleIdentity $googleIdentity): self
    {
        $this->googleIdentity = $googleIdentity;

        return $this;
    }

    public function getSlackIdentity(): ?SlackIdentity
    {
        return $this->slackIdentity;
    }

    public function setSlackIdentity(?GoogleIdentity $slackIdentity): self
    {
        $this->slackIdentity = $slackIdentity;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    //-------------------------------------------------------------------------------------------

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return string[] The user roles
     */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword(): ?string
    {
        return null;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername(): ?string
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
    }
}
