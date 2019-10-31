<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent\Data;

use JMS\Serializer\Annotation as SA;

class AppActionData
{
    /** @SA\SerializedName("type") */
    public $type;
    /**
     * @SA\SerializedName("team")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\TeamData")
     */
    public $team;
    /**
     * @SA\SerializedName("user")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\UserData")
     */
    public $user;
    /** @SA\SerializedName("api_app_id") */
    public $apiAppId;
    /** @SA\SerializedName("token") */
    public $token;
    /**
     * @SA\SerializedName("container")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\ContainerData")
     */
    public $container;
    /** @SA\SerializedName("trigger_id") */
    public $triggerId;
    /**
     * @SA\SerializedName("channel")
     * @SA\Type("\App\Slack\InteractiveComponent\Data\ChannelData")
     */
    public $channel;
    /** @SA\SerializedName("response_url") */
    public $responseUrl;
    /**
     * @SA\SerializedName("actions")
     * @SA\Type("ArrayCollection<\App\Slack\InteractiveComponent\Data\ChannelData>")
     */
    public $actions;
}
