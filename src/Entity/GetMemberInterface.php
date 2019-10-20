<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Entity;

use App\Entity\Parking\Member;

interface GetMemberInterface
{
    public function getMember(): Member;
}
