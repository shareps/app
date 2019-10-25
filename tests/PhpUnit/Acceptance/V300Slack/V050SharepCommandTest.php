<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Acceptance\V300Slack;

use App\Entity\Access\User;
use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Acceptance\AcceptanceTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group current
 */
class V050SharepCommandTest extends AcceptanceTestCase
{
    public function test_webhookUnknownCommand(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);
        $user = $this->apiLogInRole(RoleEnum::MANAGER);

        $payload = $this->getPayload($user, ['command' => 'unknown']);
        $client->request(
            'POST',
            '/webhook/slack/command',
            $payload,
            [],
            ['content-type' => 'application/x-www-form-urlencoded']
        );
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode(), $this->jsonEncode($payload));
        $this->assertContains(
            'Error: Something goes completely wrong!',
            $response->getContent(),
            $this->jsonEncode($payload)
        );
    }

    public function test_webhookUnknownTask(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);
        $user = $this->apiLogInRole(RoleEnum::MANAGER);

        $payload = $this->getPayload($user, ['text' => 'unknown']);
        $client->request(
            'POST',
            '/webhook/slack/command',
            $payload,
            [],
            ['content-type' => 'application/x-www-form-urlencoded']
        );
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode(), $this->jsonEncode($payload));
        $this->assertContains(
            'Please try again',
            $response->getContent(),
            $this->jsonEncode($payload)
        );
    }

    public function test_webhookProper(): void
    {
        $client = static::createClient([], ['HTTPS' => true]);
        $user = $this->apiLogInRole(RoleEnum::MANAGER);

        $payload = $this->getPayload($user, ['text' => 'release']);
        $client->request(
            'POST',
            '/webhook/slack/command',
            $payload,
            [],
            ['content-type' => 'application/x-www-form-urlencoded']
        );
        $response = $client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode(), $this->jsonEncode($payload));
        $this->assertContains(
            'Please select date',
            $response->getContent(),
            $this->jsonEncode($payload)
        );
    }

    private function getPayload(User $user, array $changedArguments): array
    {
        $arguments = [
            'token' => 'test',
            'team_id' => 'test',
            'team_domain' => 'test',
            'channel_id' => 'test',
            'channel_name' => 'test',
            'user_id' => $user->getSlackIdentity()->getSlackId(),
            'user_name' => 'test',
            'command' => '/sharep',
            'text' => 'release',
            'response_url' => 'test',
            'trigger_id' => 'test',
        ];

        return array_merge($arguments, $changedArguments);
    }
}
