<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Object;

use App\Slack\MessageBuilder\Element\PlainTextElement;
use App\Slack\MessageBuilder\Element\TextElementInterface;
use App\Slack\MessageBuilder\MessageInterface;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class ConfirmationDialogObject implements MessageInterface
{
    use MessageJsonSerializeTrait;

    /** @var PlainTextElement */
    private $title;
    /** @var TextElementInterface */
    private $text;
    /** @var PlainTextElement */
    private $confirm;
    /** @var PlainTextElement */
    private $deny;

    public function __construct(string $title, TextElementInterface $text, string $confirm, string $deny)
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
