<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\System;

use App\Entity\EntityInterface;
use App\Entity\Parking\Member;
use App\Entity\Traits;
use App\Enum\Entity\RequestLogTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="system_request_logs")
 */
class RequestLog implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(name="started_at", type="datetime_immutable", nullable=false)
     * @Assert\NotBlank()
     */
    private $startedAt;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(name="finished_at", type="datetime_immutable", nullable=true)
     * @Assert\NotBlank()
     */
    private $finishedAt;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="base_path", type="string", length=255, nullable=false)
     */
    private $basePath;

    /**
     * @var int
     * @ORM\Column(name="mili_seconds", type="integer", nullable=false)
     */
    private $miliSeconds;

    /**
     * @var bool
     * @ORM\Column(name="successfull", type="boolean", nullable=false)
     */
    private $successful;

    //-------------------------------------------------------------------------------------------
    /**
     * @var ArrayCollection|RequestLogDetail[]
     * @ORM\OneToMany(targetEntity="App\Entity\System\RequestLogDetail", mappedBy="requestLog")
     */
    private $requestLogDetails;

    /**
     * @var Member|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id", nullable=true)
     */
    private $member;

    //-------------------------------------------------------------------------------------------

    public function __construct(
        RequestLogTypeEnum $type,
        string $basePath,
        \DateTimeImmutable $startedAt,
        Member $member = null
    ) {
        $this->id = ShortUuid::uuid4();
        $this->member = $member;
        $this->startedAt = $startedAt;
        $this->type = $type->getValue();
        $this->basePath = $basePath;
        $this->miliSeconds = 0;
        $this->successful = false;
        $this->requestLogDetails = new ArrayCollection();
    }

    //-------------------------------------------------------------------------------------------

    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getFinishedAt(): ?\DateTimeImmutable
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeImmutable $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getMiliSeconds(): int
    {
        return $this->miliSeconds;
    }

    public function setMiliSeconds(int $miliSeconds): self
    {
        $this->miliSeconds = $miliSeconds;

        return $this;
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function setSuccessful(bool $successful): self
    {
        $this->successful = $successful;

        return $this;
    }

    /**
     * @return RequestLogDetail[]|ArrayCollection
     */
    public function getRequestLogDetails(): ArrayCollection
    {
        return $this->requestLogDetails;
    }

    /**
     * @param RequestLogDetail[]|ArrayCollection $requestLogDetails
     */
    public function setRequestLogDetails(ArrayCollection $requestLogDetails): self
    {
        $this->requestLogDetails = $requestLogDetails;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;

        return $this;
    }
}
