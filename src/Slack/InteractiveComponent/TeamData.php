<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent;

use JMS\Serializer\Annotation as SA;

class TeamData
{
    /** @SA\SerializedName("id") */
    public $id;
    /** @SA\SerializedName("domain") */
    public $domain;
}
