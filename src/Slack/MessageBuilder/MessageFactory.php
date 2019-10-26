<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder;

use App\Slack\MessageBuilder\Block\ActionsBlock;
use App\Slack\MessageBuilder\Block\BlockInterface;
use App\Slack\MessageBuilder\Block\ContextBlock;
use App\Slack\MessageBuilder\Block\DividerBlock;
use App\Slack\MessageBuilder\Block\ImageBlock;
use App\Slack\MessageBuilder\Block\InputBlock;
use App\Slack\MessageBuilder\Block\SectionBlock;
use App\Slack\MessageBuilder\Element\ActionsBlockElementInterface;
use App\Slack\MessageBuilder\Element\ButtonElement;
use App\Slack\MessageBuilder\Element\ContextBlockElementInterface;
use App\Slack\MessageBuilder\Element\DatePickerElement;
use App\Slack\MessageBuilder\Element\ImageElement;
use App\Slack\MessageBuilder\Element\InputBlockElementInterface;
use App\Slack\MessageBuilder\Element\MarkdownTextElement;
use App\Slack\MessageBuilder\Element\MultiSelectExternalElement;
use App\Slack\MessageBuilder\Element\MultiSelectStaticElement;
use App\Slack\MessageBuilder\Element\MultiSelectUserElement;
use App\Slack\MessageBuilder\Element\OverflowMenuElement;
use App\Slack\MessageBuilder\Element\PlainTextElement;
use App\Slack\MessageBuilder\Element\PlainTextInputElement;
use App\Slack\MessageBuilder\Element\SectionBlockAccessoryInterface;
use App\Slack\MessageBuilder\Element\SelectExternalElement;
use App\Slack\MessageBuilder\Element\SelectStaticElement;
use App\Slack\MessageBuilder\Element\SelectUserElement;
use App\Slack\MessageBuilder\Element\TextElementInterface;
use App\Slack\MessageBuilder\Enum\ButtonStyleEnum;
use App\Slack\MessageBuilder\Object\ConfirmationDialogObject;
use App\Slack\MessageBuilder\Object\OptionObject;

class MessageFactory
{
    public function layout(BlockInterface ...$blocks): Layout
    {
        return new Layout(...$blocks);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function blockActions(
        ActionsBlockElementInterface ...$elements
    ): ActionsBlock {
        return new ActionsBlock(...$elements);
    }

    public function blockContext(
        ContextBlockElementInterface ...$elements
    ): ContextBlock {
        return new ContextBlock(...$elements);
    }

    public function blockDivider(): DividerBlock
    {
        return new DividerBlock();
    }

    public function blockImage(
        string $imageUrl,
        string $altText,
        string $title = ''
    ): ImageBlock {
        return new ImageBlock($imageUrl, $altText, $title);
    }

    public function blockInput(
        string $label,
        InputBlockElementInterface $element,
        bool $optional = false,
        string $hint = ''
    ): InputBlock {
        return new InputBlock($label, $element, $optional, $hint);
    }

    public function blockSection(
        TextElementInterface $text,
        SectionBlockAccessoryInterface $accessory = null,
        TextElementInterface ...$fields
    ): SectionBlock {
        return new SectionBlock($text, $accessory, ...$fields);
    }

    //------------------------------------------------------------------------------------------------------------------

    public function elementButton(
        string $text,
        string $actionId,
        ButtonStyleEnum $style = null,
        ConfirmationDialogObject $confirm = null,
        string $value = '',
        string $url = ''
    ): ButtonElement {
        return new ButtonElement($text, $actionId, $style, $confirm, $value, $url);
    }

    public function elementDatePicker(
        string $actionId,
        string $placeholder = '',
        string $initialDate = '',
        ConfirmationDialogObject $confirmDialog = null
    ): DatePickerElement {
        return new DatePickerElement($actionId, $placeholder, $initialDate, $confirmDialog);
    }

    public function elementImage(
        string $imageUrl,
        string $altText
    ): ImageElement {
        return new ImageElement($imageUrl, $altText);
    }

    public function elementMarkdownText(
        string $text
    ): MarkdownTextElement {
        return new MarkdownTextElement($text);
    }

    public function elementMultiSelectExternal(
        string $placeholder,
        string $actionId,
        int $minQueryLength,
        OptionObject $initialOption = null,
        ConfirmationDialogObject $confirmDialog = null
    ): MultiSelectExternalElement {
        return new MultiSelectExternalElement($placeholder, $actionId, $minQueryLength, $initialOption, $confirmDialog);
    }

    public function elementMultiSelectStatic(
        string $placeholder,
        string $actionId,
        OptionObject $initialOption = null,
        ConfirmationDialogObject $confirmDialog = null,
        OptionObject ...$options
    ): MultiSelectStaticElement {
        return new MultiSelectStaticElement($placeholder, $actionId, $initialOption, $confirmDialog, $options);
    }

    public function elementMultiSelectUser(
        string $placeholder,
        string $actionId,
        string $initialUser,
        ConfirmationDialogObject $confirmDialog = null
    ): MultiSelectUserElement {
        return new MultiSelectUserElement($placeholder, $actionId, $initialUser, $confirmDialog);
    }

    public function elementOverflowMenu(
        string $placeholder,
        string $actionId,
        ConfirmationDialogObject $confirmDialog = null,
        OptionObject ...$options
    ): OverflowMenuElement {
        return new OverflowMenuElement($placeholder, $actionId, $confirmDialog, $options);
    }

    public function elementPlainText(
        string $text
    ): PlainTextElement {
        return new PlainTextElement($text);
    }

    public function elementPlainTextInput(
        string $actionId,
        string $placeholder = '',
        string $initialValue = '',
        bool $multiline = false,
        int $minLength = 1,
        int $maxLength = 3000
    ): PlainTextInputElement {
        return new PlainTextInputElement($actionId, $placeholder, $initialValue, $multiline, $minLength, $maxLength);
    }

    public function elementSelectExternal(
        string $placeholder,
        string $actionId,
        int $minQueryLength,
        OptionObject $initialOption = null,
        ConfirmationDialogObject $confirmDialog = null
    ): SelectExternalElement {
        return new SelectExternalElement($placeholder, $actionId, $minQueryLength, $initialOption, $confirmDialog);
    }

    public function elementSelectStatic(
        string $placeholder,
        string $actionId,
        OptionObject $initialOption = null,
        ConfirmationDialogObject $confirmDialog = null,
        OptionObject ...$options
    ): SelectStaticElement {
        return new SelectStaticElement($placeholder, $actionId, $initialOption, $confirmDialog, $options);
    }

    public function elementSelectUserText(
        string $placeholder,
        string $actionId,
        string $initialUser,
        ConfirmationDialogObject $confirmDialog = null
    ): SelectUserElement {
        return new SelectUserElement($placeholder, $actionId, $initialUser, $confirmDialog);
    }

    //------------------------------------------------------------------------------------------------------------------
}
