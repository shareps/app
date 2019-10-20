<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Object;

use App\Slack\Message\Element\MarkdownTextElement;
use App\Slack\Message\Element\PlainTextElement;
use App\Slack\Message\MessageInterface;
use App\Slack\Message\MessageJsonSerializeTrait;

class ConfirmationDialogObject implements MessageInterface
{
    use MessageJsonSerializeTrait;

    /** @var PlainTextElement */
    private $title;
    /** @var MarkdownTextElement */
    private $text;
    /** @var PlainTextElement */
    private $confirm;
    /** @var PlainTextElement */
    private $deny;

    public function __construct(string $title, MarkdownTextElement $text, string $confirm, string $deny)
    {
        if (\strlen($title) > 100) {
            throw new \InvalidArgumentException('$title too long!');
        }
        if (\strlen($text->jsonSerialize()['text']) > 300) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($confirm) > 30) {
            throw new \InvalidArgumentException('$confirm too long!');
        }
        if (\strlen($deny) > 30) {
            throw new \InvalidArgumentException('$deny too long!');
        }

        $this->title = new PlainTextElement($title);
        $this->text = $text;
        $this->confirm = new PlainTextElement($confirm);
        $this->deny = new PlainTextElement($deny);
    }
}
