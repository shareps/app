<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Block;

use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

class DividerBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;

    public function __construct()
    {
        $this->type = MessageTypeEnum::BLOCK_DIVIDER;
    }
}
