<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V200ApiFull;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;

class V110SharepCommandTest extends AcceptanceTestCase
{
    public function test_emptyCommandData(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);

        $client->request('GET', '/webhook/slack/command');
        $response = $client->getResponse();

        $this->assertSame(500, $response->getStatusCode());
    }
}
