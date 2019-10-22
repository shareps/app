<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Element;

use App\Slack\MessageBuilder\Enum\ButtonStyleEnum;
use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;
use App\Slack\MessageBuilder\Object\ConfirmationDialogObject;

class ButtonElement implements SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $text;
    /** @var string */
    private $actionId;
    /** @var ButtonStyleEnum|null */
    private $style;
    /** @var ConfirmationDialogObject|null */
    private $confirm;
    /** @var string */
    private $value;
    /** @var string */
    private $url;

    public function __construct(string $text, string $actionId, ButtonStyleEnum $style = null, ConfirmationDialogObject $confirm = null, string $value = '', string $url = '')
    {
        if (\strlen($text) > 75) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\strlen($value) > 2000) {
            throw new \InvalidArgumentException('$value too long!');
        }
        if (\strlen($url) > 3000) {
            throw new \InvalidArgumentException('$url too long!');
        }

        $this->type = MessageTypeEnum::ELEMENT_BUTTON;
        $this->text = new PlainTextElement($text);
        $this->actionId = $actionId;
        $this->style = $style;
        $this->confirm = $confirm;
        $this->value = $value;
        $this->url = $url;
    }
}
