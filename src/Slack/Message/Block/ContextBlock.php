<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Block;

use App\Slack\Message\Element\ContextBlockElementInterface;
use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

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
