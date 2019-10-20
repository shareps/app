<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Element;

use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

class PlainTextInputElement implements SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $actionId;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $initialValue;
    /** @var bool */
    private $multiline;
    /** @var int */
    private $minLength;
    /** @var int */
    private $maxLength;

    public function __construct(string $actionId, string $placeholder = '', string $initialValue = '', bool $multiline = false, int $minLength = 1, int $maxLength = 3000)
    {
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$placeholder too long!');
        }

        $this->type = MessageTypeEnum::ELEMENT_INPUT_PLAIN_TEXT;
        $this->actionId = $actionId;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->initialValue = $initialValue;
        $this->multiline = $multiline;
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }
}
