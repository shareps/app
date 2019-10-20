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
 * @method static RoleEnum USER()
 * @method static RoleEnum DUMMY()
 * @method static RoleEnum MEMBER()
 * @method static RoleEnum MANAGER()
 * @method static RoleEnum SYSTEM()
 */
class RoleEnum extends Enum
{
    public const USER = 'ROLE_USER';
    public const DUMMY = 'ROLE_DUMMY';
    public const MEMBER = 'ROLE_MEMBER';
    public const MANAGER = 'ROLE_MANAGER';
    public const SYSTEM = 'ROLE_SYSTEM';
}
