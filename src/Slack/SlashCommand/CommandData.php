<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand;

use JMS\Serializer\Annotation as SA;

class CommandData
{
    /**
     * @SA\SerializedName("token")
     * @SA\Type("string")
     */
    public $token;
    /**
     * @SA\SerializedName("team_id")
     * @SA\Type("string")
     */
    public $teamId;
    /**
     * @SA\SerializedName("team_domain")
     * @SA\Type("string")
     */
    public $teamDomain;
    /**
     * @SA\SerializedName("channel_id")
     * @SA\Type("string")
     */
    public $channelId;
    /**
     * @SA\SerializedName("channel_name")
     * @SA\Type("string")
     */
    public $channelName;
    /**
     * @SA\SerializedName("user_id")
     * @SA\Type("string")
     */
    public $userId;
    /**
     * @SA\SerializedName("user_name")
     * @SA\Type("string")
     */
    public $userName;
    /**
     * @SA\SerializedName("command")
     * @SA\Type("string")
     */
    public $command;
    /**
     * @SA\SerializedName("text")
     * @SA\Type("string")
     */
    public $text;
    /**
     * @SA\SerializedName("response_url")
     * @SA\Type("string")
     */
    public $responseUrl;
    /**
     * @SA\SerializedName("trigger_id")
     * @SA\Type("string")
     */
    public $triggerId;
}
