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

class DatePickerElement implements
    SectionBlockElementInterface,
    ActionsBlockElementInterface,
    InputBlockElementInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $actionId;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $initialDate;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;

    public function __construct(string $actionId, string $placeholder = '', string $initialDate = '', ConfirmationDialogObject $confirmDialog = null)
    {
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$placeholder too long!');
        }

        $this->type = MessageTypeEnum::ELEMENT_DATE_PICKER;
        $this->actionId = $actionId;
        if ('' !== $placeholder) {
            $this->placeholder = new PlainTextElement($placeholder);
        }
        $this->initialDate = $initialDate;
        $this->confirmDialog = $confirmDialog;
    }
}
