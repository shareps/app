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
 * @method static PermissionEnum PARKING_AVAILABILITY_CREATE()
 * @method static PermissionEnum PARKING_AVAILABILITY_READ()
 * @method static PermissionEnum PARKING_AVAILABILITY_UPDATE()
 * @method static PermissionEnum PARKING_AVAILABILITY_DELETE()
 * @method static PermissionEnum PARKING_AVAILABILITY_BREAK_CREATE()
 * @method static PermissionEnum PARKING_AVAILABILITY_BREAK_READ()
 * @method static PermissionEnum PARKING_AVAILABILITY_BREAK_UPDATE()
 * @method static PermissionEnum PARKING_AVAILABILITY_BREAK_DELETE()
 * @method static PermissionEnum PARKING_MEMBER_CREATE()
 * @method static PermissionEnum PARKING_MEMBER_READ()
 * @method static PermissionEnum PARKING_MEMBER_UPDATE()
 * @method static PermissionEnum PARKING_MEMBER_DELETE()
 * @method static PermissionEnum PARKING_MEMBER_NEED_CREATE()
 * @method static PermissionEnum PARKING_MEMBER_NEED_READ()
 * @method static PermissionEnum PARKING_MEMBER_NEED_UPDATE()
 * @method static PermissionEnum PARKING_MEMBER_NEED_DELETE()
 * @method static PermissionEnum PARKING_MEMBERSHIP_CREATE()
 * @method static PermissionEnum PARKING_MEMBERSHIP_READ()
 * @method static PermissionEnum PARKING_MEMBERSHIP_UPDATE()
 * @method static PermissionEnum PARKING_MEMBERSHIP_DELETE()
 * @method static PermissionEnum PARKING_RESERVATION_CREATE()
 * @method static PermissionEnum PARKING_RESERVATION_READ()
 * @method static PermissionEnum PARKING_RESERVATION_UPDATE()
 * @method static PermissionEnum PARKING_RESERVATION_DELETE()
 */
class PermissionEnum extends Enum
{
    public const PARKING_AVAILABILITY_CREATE = 'PARKING_AVAILABILITY_CREATE';
    public const PARKING_AVAILABILITY_READ = 'PARKING_AVAILABILITY_READ';
    public const PARKING_AVAILABILITY_UPDATE = 'PARKING_AVAILABILITY_UPDATE';
    public const PARKING_AVAILABILITY_DELETE = 'PARKING_AVAILABILITY_DELETE';

    public const PARKING_AVAILABILITY_BREAK_CREATE = 'PARKING_AVAILABILITY_BREAK_CREATE';
    public const PARKING_AVAILABILITY_BREAK_READ = 'PARKING_AVAILABILITY_BREAK_READ';
    public const PARKING_AVAILABILITY_BREAK_UPDATE = 'PARKING_AVAILABILITY_BREAK_UPDATE';
    public const PARKING_AVAILABILITY_BREAK_DELETE = 'PARKING_AVAILABILITY_BREAK_DELETE';

    public const PARKING_MEMBER_CREATE = 'PARKING_MEMBER_CREATE';
    public const PARKING_MEMBER_READ = 'PARKING_MEMBER_READ';
    public const PARKING_MEMBER_UPDATE = 'PARKING_MEMBER_UPDATE';
    public const PARKING_MEMBER_DELETE = 'PARKING_MEMBER_DELETE';

    public const PARKING_MEMBER_NEED_CREATE = 'PARKING_MEMBER_NEED_CREATE';
    public const PARKING_MEMBER_NEED_READ = 'PARKING_MEMBER_NEED_READ';
    public const PARKING_MEMBER_NEED_UPDATE = 'PARKING_MEMBER_NEED_UPDATE';
    public const PARKING_MEMBER_NEED_DELETE = 'PARKING_MEMBER_NEED_DELETE';

    public const PARKING_MEMBERSHIP_CREATE = 'PARKING_MEMBERSHIP_CREATE';
    public const PARKING_MEMBERSHIP_READ = 'PARKING_MEMBERSHIP_READ';
    public const PARKING_MEMBERSHIP_UPDATE = 'PARKING_MEMBERSHIP_UPDATE';
    public const PARKING_MEMBERSHIP_DELETE = 'PARKING_MEMBERSHIP_DELETE';

    public const PARKING_RESERVATION_CREATE = 'PARKING_RESERVATION_CREATE';
    public const PARKING_RESERVATION_READ = 'PARKING_RESERVATION_READ';
    public const PARKING_RESERVATION_UPDATE = 'PARKING_RESERVATION_UPDATE';
    public const PARKING_RESERVATION_DELETE = 'PARKING_RESERVATION_DELETE';
}
