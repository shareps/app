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
use App\Slack\MessageBuilder\Object\OptionGroupObject;
use App\Slack\MessageBuilder\Object\OptionObject;

class MultiSelectStaticGroupElement implements SectionBlockElementInterface, InputBlockElementInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $actionId;
    /** @var array|OptionObject[] */
    private $initialOptions;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;
    /** @var array|OptionGroupObject[] */
    private $optionGroups;

    public function __construct(
        string $placeholder,
        string $actionId,
        array $initialOptions = [],
        ConfirmationDialogObject $confirmDialog = null,
        OptionGroupObject ...$optionGroups
    ) {
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\count($optionGroups) > 100) {
            throw new \InvalidArgumentException('$optionGroups too long!');
        }
        if (0 === \count($optionGroups)) {
            throw new \InvalidArgumentException('$optionGroups too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_MULTI_SELECT_STATIC;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->initialOptions = $initialOptions;
        $this->confirmDialog = $confirmDialog;
        $this->optionGroups = $optionGroups;
    }
}
