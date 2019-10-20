<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity;

use App\Enum\Functional\RoleEnum;

interface GetRoleInterface
{
    public function getRole(): RoleEnum;
}
