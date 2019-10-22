<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Block;

use App\Slack\MessageBuilder\Element\ActionsBlockElementInterface;
use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class ActionsBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var array|ActionsBlockElementInterface[] */
    private $elements;

    public function __construct(ActionsBlockElementInterface ...$elements)
    {
        $this->type = MessageTypeEnum::BLOCK_ACTIONS;
        $this->elements = $elements;
    }
}
