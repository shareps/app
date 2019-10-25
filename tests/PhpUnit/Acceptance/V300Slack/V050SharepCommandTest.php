<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group current
 */
class V050SharepCommandTest extends AcceptanceTestCase
{
    public function test_webhook(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);

        $client->request(
            'POST',
            '/webhook/slack/command',
            ['user_id' => '123'],
            [],
            ['content-type' => 'application/x-www-form-urlencoded']
        );
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
