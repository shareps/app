<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Enum\Functional;

use MyCLabs\Enum\Enum;

/**
 * @method static ApplicationEnum DATE_FORMAT()
 * @method static ApplicationEnum PLACE_POINTS()
 * @method static ApplicationEnum SYSTEM_MEMBER_NAME()
 * @method static ApplicationEnum SYSTEM_MEMBER_EMAIL()
 */
class ApplicationEnum extends Enum
{
    public const DATE_FORMAT = 'Y-m-d';
    public const PLACE_POINTS = 1000;
    public const SYSTEM_MEMBER_NAME = 'System';
    public const SYSTEM_MEMBER_EMAIL = 'system@example.com';
}
