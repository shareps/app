<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Element;

use App\Slack\MessageBuilder\Enum\TextTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class MarkdownTextElement implements TextElementInterface, SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $text;
    /** @var bool */
    private $verbatim;

    public function __construct(string $text)
    {
        if (\strlen($text) > 3000) {
            throw new \InvalidArgumentException('Text too long!');
        }

        $this->type = TextTypeEnum::MARKDOWN;
        $this->text = $text;
        $this->verbatim = false;
    }
}
