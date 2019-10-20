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

class OptionObject implements MessageInterface
{
    use MessageJsonSerializeTrait;

    /** @var PlainTextElement */
    private $text;
    /** @var string */
    private $value;
    /** @var string */
    private $url;

    public function __construct(string $text, string $value, string $url = '')
    {
        if (\strlen($text) > 75) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($value) > 75) {
            throw new \InvalidArgumentException('$value too long!');
        }
        if (\strlen($url) > 3000) {
            throw new \InvalidArgumentException('$url too long!');
        }

        $this->text = new PlainTextElement($text);
        $this->value = $value;
        $this->url = $url;
    }
}
