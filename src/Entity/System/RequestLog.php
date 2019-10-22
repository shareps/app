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
     * @ORM\Column(name="group", type="string", length=255, nullable=false)
     */
    private $group;

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
     * @var Member
     * @ORM\ManyToOne(targetEntity="App\Entity\Parking\Member")
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id", nullable=true)
     */
    private $member;

    //-------------------------------------------------------------------------------------------

    public function __construct(
        Member $member,
        \DateTimeImmutable $startedAt,
        RequestLogTypeEnum $type,
        string $group
    ) {
        $this->id = ShortUuid::uuid4();
        $this->member = $member;
        $this->startedAt = $startedAt;
        $this->type = $type->getValue();
        $this->group = $group;
        $this->miliSeconds = 0;
        $this->successful = false;
        $this->requestLogDetails = new ArrayCollection();
    }

    //-------------------------------------------------------------------------------------------
}
