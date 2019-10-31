<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand\Data;

use JMS\Serializer\Annotation as SA;

class CommandData
{
    /**
     * @var string
     * @SA\SerializedName("token")
     * @SA\Type("string")
     */
    public $token;
    /**
     * @var string
     * @SA\SerializedName("team_id")
     * @SA\Type("string")
     */
    public $teamId;
    /**
     * @var string
     * @SA\SerializedName("team_domain")
     * @SA\Type("string")
     */
    public $teamDomain;
    /**
     * @var string
     * @SA\SerializedName("channel_id")
     * @SA\Type("string")
     */
    public $channelId;
    /**
     * @var string
     * @SA\SerializedName("channel_name")
     * @SA\Type("string")
     */
    public $channelName;
    /**
     * @var string
     * @SA\SerializedName("user_id")
     * @SA\Type("string")
     */
    public $userId;
    /**
     * @var string
     * @SA\SerializedName("user_name")
     * @SA\Type("string")
     */
    public $userName;
    /**
     * @var string
     * @SA\SerializedName("command")
     * @SA\Type("string")
     */
    public $command;
    /**
     * @var string
     * @SA\SerializedName("text")
     * @SA\Type("string")
     */
    public $text;
    /**
     * @var string
     * @SA\SerializedName("response_url")
     * @SA\Type("string")
     */
    public $responseUrl;
    /**
     * @var string
     * @SA\SerializedName("trigger_id")
     * @SA\Type("string")
     */
    public $triggerId;
}
