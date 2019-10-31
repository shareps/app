<?php

/** @noinspection DuplicatedCode, UnusedConstructorDependenciesInspection */

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

class SelectExternalElement implements SectionBlockElementInterface, ActionsBlockElementInterface, InputBlockElementInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $actionId;
    /** @var int */
    private $minQueryLength;
    /** @var OptionObject */
    private $initialOption;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;

    public function __construct(string $placeholder, string $actionId, int $minQueryLength, OptionObject $initialOption = null, ConfirmationDialogObject $confirmDialog = null)
    {
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if ($minQueryLength < 1) {
            throw new \InvalidArgumentException('$minQueryLength too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_SELECT_STATIC;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->minQueryLength = $minQueryLength;
        $this->initialOption = $initialOption;
        $this->confirmDialog = $confirmDialog;
    }
}
