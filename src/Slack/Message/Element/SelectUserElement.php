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

class SelectUserElement implements SectionBlockAccessoryInterface
{
    use MessageJsonSerializeTrait;

    /** @var MessageTypeEnum */
    private $type;
    /** @var PlainTextElement */
    private $placeholder;
    /** @var string */
    private $actionId;
    /** @var string */
    private $initialUser;
    /** @var ConfirmationDialogObject */
    private $confirmDialog;

    public function __construct(string $placeholder, string $actionId, string $initialUser, ConfirmationDialogObject $confirmDialog = null)
    {
        if (\strlen($placeholder) > 150) {
            throw new \InvalidArgumentException('$text too long!');
        }
        if (\strlen($actionId) > 255) {
            throw new \InvalidArgumentException('$actionId too long!');
        }

        $this->type = MessageTypeEnum::ELEMENT_SELECT_USER;
        $this->placeholder = new PlainTextElement($placeholder);
        $this->actionId = $actionId;
        $this->initialUser = $initialUser;
        $this->confirmDialog = $confirmDialog;
    }
}
