<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Enum\Entity;

use MyCLabs\Enum\Enum;

/**
 * @method static JournalTypeEnum FILL()
 * @method static JournalTypeEnum RESERVE()
 */
class JournalTypeEnum extends Enum
{
    public const FILL = 'FILL';
    public const RESERVE = 'RESERVE';
}
