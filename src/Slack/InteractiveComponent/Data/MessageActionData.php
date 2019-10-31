<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class MessageActionData
{
    /** @SA\SerializedName("type") */
    public $type;
    /** @SA\SerializedName("callback_id") */
    public $callbackId;
    /** @SA\SerializedName("trigger_id") */
    public $triggerId;
    /** @SA\SerializedName("response_url") */
    public $responseUrl;
    /**
     * @SA\SerializedName("user")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\UserData")
     */
    public $user;
    /**
     * @SA\SerializedName("team")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\TeamData")
     */
    public $team;
    /** @SA\SerializedName("message") */
    public $message;
    /**
     * @SA\SerializedName("actions")
     * @SA\Type("ArrayCollection<\App\Slack\InteractiveComponent\Data\ChannelData>")
     */
    public $actions;
    /** @SA\SerializedName("token") */
    public $token;
    /**
     * @SA\SerializedName("channel")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\ChannelData")
     */
    public $channel;
}
