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

class RadioButtonGroupElement implements SectionBlockElementInterface, ActionsBlockElementInterface, InputBlockElementInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $actionId;
    /** @var ConfirmationDialogObject|null */
    private $confirmDialog;
    /** @var OptionObject|null */
    private $initialOption;
    /** @var array|OptionObject[] */
    private $options;

    public function __construct(string $actionId, ConfirmationDialogObject $confirmDialog = null, OptionObject $initialOption = null, OptionObject ...$options)
    {
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\count($options) < 1) {
            throw new \InvalidArgumentException('$options too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_RADIO_BUTTONS;
        $this->actionId = $actionId;
        $this->confirmDialog = $confirmDialog;
        $this->initialOption = $initialOption;
        $this->options = $options;
    }
}
