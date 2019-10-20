<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Block;

use App\Slack\Message\Element\InputBlockElementInterface;
use App\Slack\Message\Element\PlainTextElement;
use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

class InputBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $label;
    /** @var InputBlockElementInterface */
    private $element;
    /** @var bool */
    private $optional;
    /** @var PlainTextElement|null */
    private $hint;

    public function __construct(string $label, InputBlockElementInterface $element, bool $optional = false, string $hint = '')
    {
        if (\strlen($label) > 2000) {
            throw new \InvalidArgumentException('$label too long!');
        }
        if (\strlen($hint) > 2000) {
            throw new \InvalidArgumentException('$hint too long!');
        }
        $this->type = MessageTypeEnum::BLOCK_INPUT;
        $this->label = new PlainTextElement($label);
        $this->element = $element;
        $this->optional = $optional;
        if ('' !== $hint) {
            $this->hint = new PlainTextElement($hint);
        }
    }
}
