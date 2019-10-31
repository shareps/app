<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class ContainerData
{
    /** @SA\SerializedName("type") */
    public $type;
    /** @SA\SerializedName("message_ts") */
    public $messageTs;
    /** @SA\SerializedName("channel_id") */
    public $channelId;
    /** @SA\SerializedName("is_ephemeral") */
    public $isEphemeral;
}
