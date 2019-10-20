<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V050SharepCommandTest extends AcceptanceTestCase
{
    public function test_webhook(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);

        $client->request('GET', '/webhook/slack/command');
        $response = $client->getResponse();

        $this->assertSame(500, $response->getStatusCode());
    }
}
