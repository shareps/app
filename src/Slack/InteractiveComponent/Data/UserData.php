<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class UserData
{
    /** @SA\SerializedName("id") */
    public $id;
    /** @SA\SerializedName("username") */
    public $username;
    /** @SA\SerializedName("username") */
    public $name;
    /** @SA\SerializedName("team_id") */
    public $teamId;
}
