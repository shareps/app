<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class ActionData
{
    /** @SA\SerializedName("id") */
    public $type;
    /** @SA\SerializedName("action_id") */
    public $actionId;
    /** @SA\SerializedName("block_id") */
    public $blockId;
    /** @SA\SerializedName("selected_date") */
    public $selectedDate;
    /** @SA\SerializedName("value") */
    public $value;
    /** @SA\SerializedName("action_ts") */
    public $actionTs;
}
