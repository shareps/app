<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class ChannelData
{
    /** @SA\SerializedName("id") */
    public $type;
    /** @SA\SerializedName("name") */
    public $name;
}
