<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Client;

use JoliCode\Slack\Api\Client;

class ClientFactory
{
    /** @var string */
    private $botToken;

    public function __construct(string $botToken)
    {
        $this->botToken = $botToken;
    }

    public function createBotClient(): Client
    {
        return \JoliCode\Slack\ClientFactory::create($this->botToken);
    }
}
