<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Functional\Slack\SlashCommand;

use App\Slack\SlashCommand\Data\CommandData;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommandDataTest extends KernelTestCase
{
    /** @var Application|null */
    private static $application;
    /** @var SerializerInterface|null */
    private static $serializer;

    public static function setUpBeforeClass(): void
    {
        self::bootKernel();
        self::$application = new Application(self::$kernel);
        self::$serializer = self::$container->get(SerializerInterface::class);
    }

    public function testSerializer(): void
    {
        $inputData = [
            'token' => 'tokenTest',
            'team_id' => 'teamIdTest',
            'team_domain' => 'teamDomainTest',
            'channel_id' => 'channelIdTest',
            'channel_name' => 'channelNameTest',
            'user_id' => 'userIdTest',
            'user_name' => 'userNameTest',
            'command' => 'commandTest',
            'text' => 'textTest',
            'response_url' => 'responseUrlTest',
            'trigger_id' => 'triggerIdTest',
        ];

        $expectedData = [
            'token' => 'tokenTest',
            'teamId' => 'teamIdTest',
            'teamDomain' => 'teamDomainTest',
            'channelId' => 'channelIdTest',
            'channelName' => 'channelNameTest',
            'userId' => 'userIdTest',
            'userName' => 'userNameTest',
            'command' => 'commandTest',
            'text' => 'textTest',
            'responseUrl' => 'responseUrlTest',
            'triggerId' => 'triggerIdTest',
        ];

        $commandData = self::$serializer->deserialize(
            json_encode($inputData, JSON_THROW_ON_ERROR),
            CommandData::class,
            'json'
        );

        $this->assertSame($expectedData['token'], $commandData->token);
        $this->assertSame($expectedData, (array) $commandData);
    }
}
