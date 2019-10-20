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
 * @method static ButtonStyleEnum PRIMARY()
 * @method static ButtonStyleEnum DANGER()
 */
class ButtonStyleEnum extends Enum
{
    public const PRIMARY = 'primary';
    public const DANGER = 'danger';
}
