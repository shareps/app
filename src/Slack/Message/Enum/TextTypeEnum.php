<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static TextTypeEnum MARKDOWN()
 * @method static TextTypeEnum PLAIN_TEXT()
 */
class TextTypeEnum extends Enum
{
    public const MARKDOWN = 'mrkdwn';
    public const PLAIN_TEXT = 'plain_text';
}
