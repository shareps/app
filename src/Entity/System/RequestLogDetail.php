<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity\System;

use App\Entity\EntityInterface;
use App\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use PascalDeVink\ShortUuid\ShortUuid;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="system_request_log_details")
 */
class RequestLogDetail implements EntityInterface
{
    use Traits\PropertyIdGeneratedTrait;

    /**
     * @var string
     * @ORM\Column(name="path", type="text", nullable=false)
     */
    private $path;

    /**
     * @var string
     * @ORM\Column(name="meta", type="text", nullable=false)
     */
    private $meta;

    //-------------------------------------------------------------------------------------------

    /**
     * @var RequestLog
     * @ORM\ManyToOne(targetEntity="App\Entity\System\RequestLog", inversedBy="requestLogDetails")
     * @ORM\JoinColumn(name="request_log_id", referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    private $requestLog;

    //-------------------------------------------------------------------------------------------

    public function __construct(RequestLog $requestLog, string $path, string $meta)
    {
        $this->id = ShortUuid::uuid4();
        $this->requestLog = $requestLog;
        $this->path = $path;
        $this->meta = $meta;
    }

    //-------------------------------------------------------------------------------------------
}
