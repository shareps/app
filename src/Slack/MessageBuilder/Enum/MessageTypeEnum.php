<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static MessageTypeEnum BLOCK_SECTION()
 * @method static MessageTypeEnum BLOCK_DIVIDER()
 * @method static MessageTypeEnum BLOCK_IMAGE()
 * @method static MessageTypeEnum BLOCK_ACTIONS()
 * @method static MessageTypeEnum BLOCK_CONTEXT()
 * @method static MessageTypeEnum BLOCK_INPUT()
 * @method static MessageTypeEnum ELEMENT_IMAGE()
 * @method static MessageTypeEnum ELEMENT_BUTTON()
 * @method static MessageTypeEnum ELEMENT_OVERFLOW_MENU()
 * @method static MessageTypeEnum ELEMENT_DATE_PICKER()
 * @method static MessageTypeEnum ELEMENT_INPUT_PLAIN_TEXT()
 * @method static MessageTypeEnum ELEMENT_TEXT_MARKDOWN()
 * @method static MessageTypeEnum ELEMENT_TEXT_PLAIN()
 * @method static MessageTypeEnum ELEMENT_SELECT_STATIC()
 * @method static MessageTypeEnum ELEMENT_SELECT_EXTERNAL()
 * @method static MessageTypeEnum ELEMENT_SELECT_USER()
 * @method static MessageTypeEnum ELEMENT_SELECT_CONVERSATION()
 * @method static MessageTypeEnum ELEMENT_SELECT_CHANNEL()
 * @method static MessageTypeEnum ELEMENT_MULTI_SELECT_STATIC()
 * @method static MessageTypeEnum ELEMENT_MULTI_SELECT_EXTERNAL()
 * @method static MessageTypeEnum ELEMENT_MULTI_SELECT_USER()
 * @method static MessageTypeEnum ELEMENT_MULTI_SELECT_CONVERSATION()
 * @method static MessageTypeEnum ELEMENT_MULTI_SELECT_CHANNEL()
 */
class MessageTypeEnum extends Enum
{
    public const BLOCK_SECTION = 'section';
    public const BLOCK_DIVIDER = 'divider';
    public const BLOCK_IMAGE = 'image';
    public const BLOCK_ACTIONS = 'actions';
    public const BLOCK_CONTEXT = 'context';
    public const BLOCK_INPUT = 'input';

    public const ELEMENT_IMAGE = 'image';
    public const ELEMENT_BUTTON = 'button';
    public const ELEMENT_OVERFLOW_MENU = 'overflow';
    public const ELEMENT_DATE_PICKER = 'datepicker';
    public const ELEMENT_INPUT_PLAIN_TEXT = 'plain_text_input';

    public const ELEMENT_TEXT_MARKDOWN = 'mrkdwn';
    public const ELEMENT_TEXT_PLAIN = 'plain_text';

    public const ELEMENT_SELECT_STATIC = 'static_select';
    public const ELEMENT_SELECT_EXTERNAL = 'external_select';
    public const ELEMENT_SELECT_USER = 'users_select';
    public const ELEMENT_SELECT_CONVERSATION = 'conversations_select';
    public const ELEMENT_SELECT_CHANNEL = 'channels_select';

    public const ELEMENT_MULTI_SELECT_STATIC = 'multi_static_select';
    public const ELEMENT_MULTI_SELECT_EXTERNAL = 'multi_external_select';
    public const ELEMENT_MULTI_SELECT_USER = 'multi_users_select';
    public const ELEMENT_MULTI_SELECT_CONVERSATION = 'multi_conversations_select';
    public const ELEMENT_MULTI_SELECT_CHANNEL = 'multi_channels_select';
}
