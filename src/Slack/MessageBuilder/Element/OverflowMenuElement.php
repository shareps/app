<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Element;

use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;
use App\Slack\MessageBuilder\Object\ConfirmationDialogObject;
use App\Slack\MessageBuilder\Object\OptionObject;

class OverflowMenuElement implements SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $actionId;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;
    /** @var array|OptionObject[] */
    private $options;

    public function __construct(string $placeholder, string $actionId, ConfirmationDialogObject $confirmDialog = null, OptionObject ...$options)
    {
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\count($options) > 5) {
            throw new \InvalidArgumentException('$options too long!');
        }
        if (\count($options) < 2) {
            throw new \InvalidArgumentException('$options too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_OVERFLOW_MENU;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->confirmDialog = $confirmDialog;
        $this->options = $options;
    }
}
