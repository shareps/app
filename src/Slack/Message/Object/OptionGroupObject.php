<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Object;

use App\Slack\Message\Element\PlainTextElement;
use App\Slack\Message\MessageInterface;
use App\Slack\Message\MessageJsonSerializeTrait;

class OptionGroupObject implements MessageInterface
{
    use MessageJsonSerializeTrait;

    /** @var PlainTextElement */
    private $label;
    /** @var array|OptionObject[] */
    private $options;

    public function __construct(string $label, OptionObject ...$options)
    {
        if (\strlen($label) > 75) {
            throw new \InvalidArgumentException('$label too long!');
        }
        if (\count($options) > 100) {
            throw new \InvalidArgumentException('$options too long!');
        }
        if (0 === \count($options)) {
            throw new \InvalidArgumentException('$options too short!');
        }

        $this->label = new PlainTextElement($label);
        $this->options = $options;
    }
}
