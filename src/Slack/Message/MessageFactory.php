<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message;

use App\Slack\Message\Block\ActionsBlock;
use App\Slack\Message\Block\BlockInterface;
use App\Slack\Message\Block\ContextBlock;
use App\Slack\Message\Block\DividerBlock;
use App\Slack\Message\Block\ImageBlock;
use App\Slack\Message\Block\InputBlock;
use App\Slack\Message\Block\SectionBlock;
use App\Slack\Message\Element\ActionsBlockElementInterface;
use App\Slack\Message\Element\ButtonElement;
use App\Slack\Message\Element\ContextBlockElementInterface;
use App\Slack\Message\Element\DatePickerElement;
use App\Slack\Message\Element\ImageElement;
use App\Slack\Message\Element\InputBlockElementInterface;
use App\Slack\Message\Element\MarkdownTextElement;
use App\Slack\Message\Element\MultiSelectExternalElement;
use App\Slack\Message\Element\MultiSelectStaticElement;
use App\Slack\Message\Element\MultiSelectUserElement;
use App\Slack\Message\Element\OverflowMenuElement;
use App\Slack\Message\Element\PlainTextElement;
use App\Slack\Message\Element\PlainTextInputElement;
use App\Slack\Message\Element\SectionBlockAccessoryInterface;
use App\Slack\Message\Element\SelectExternalElement;
use App\Slack\Message\Element\SelectStaticElement;
use App\Slack\Message\Element\SelectUserElement;
use App\Slack\Message\Element\TextElementInterface;
use App\Slack\Message\Enum\ButtonStyleEnum;
use App\Slack\Message\Object\ConfirmationDialogObject;
use App\Slack\Message\Object\OptionObject;

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

    public function MultiSelectUserText(
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
