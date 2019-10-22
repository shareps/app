<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Block;

use App\Slack\MessageBuilder\Element\ContextBlockElementInterface;
use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class ContextBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var array|ContextBlockElementInterface[] */
    private $elements;

    public function __construct(ContextBlockElementInterface ...$elements)
    {
        $this->type = MessageTypeEnum::BLOCK_CONTEXT;
        $this->elements = $elements;
    }
}
