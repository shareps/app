<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Block;

use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

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
