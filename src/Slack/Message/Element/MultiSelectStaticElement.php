<?php

/** @noinspection DuplicatedCode, UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Element;

use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;
use App\Slack\Message\Object\ConfirmationDialogObject;
use App\Slack\Message\Object\OptionObject;

class MultiSelectStaticElement implements SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $actionId;
    /** @var OptionObject */
    private $initialOption;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;
    /** @var array|OptionObject[] */
    private $options;

    public function __construct(
        string $placeholder,
        string $actionId,
        OptionObject $initialOption = null,
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
            throw new \InvalidArgumentException('$url too short!');
        }

        $this->type = MessageTypeEnum::ELEMENT_MULTI_SELECT_STATIC;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->initialOption = $initialOption;
        $this->confirmDialog = $confirmDialog;
        $this->options = $options;
    }
}
