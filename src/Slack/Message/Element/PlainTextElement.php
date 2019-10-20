<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Element;

use App\Slack\Message\Enum\TextTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

class PlainTextElement implements TextElementInterface, SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $text;
    /** @var bool */
    private $emoji;

    public function __construct(string $text)
    {
        if (\strlen($text) > 3000) {
            throw new \InvalidArgumentException('Text too long!');
        }

        $this->type = TextTypeEnum::PLAIN_TEXT;
        $this->text = $text;
        $this->emoji = false;
    }
}
