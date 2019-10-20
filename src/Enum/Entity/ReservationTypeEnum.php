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
 * @method static ReservationTypeEnum REVOKED()
 * @method static ReservationTypeEnum ASSIGNED()
 */
class ReservationTypeEnum extends Enum
{
    public const REVOKED = 'REVOKED';
    public const ASSIGNED = 'ASSIGNED';
}
