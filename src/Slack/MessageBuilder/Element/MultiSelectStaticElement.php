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

class MultiSelectStaticElement implements SectionBlockElementInterface, InputBlockElementInterface
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
    /** @var array|OptionObject[] */
    private $options;

    public function __construct(
        string $placeholder,
        string $actionId,
        array $initialOptions = [],
        ConfirmationDialogObject $confirmDialog = null,
        OptionObject ...$options
    ) {
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }
        if (\count($options) > 100) {
            throw new \InvalidArgumentException('$options too long!');
        }
        if (0 === \count($options)) {
            throw new \InvalidArgumentException('$options too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_MULTI_SELECT_STATIC;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->initialOptions = $initialOptions;
        $this->confirmDialog = $confirmDialog;
        $this->options = $options;
    }
}
