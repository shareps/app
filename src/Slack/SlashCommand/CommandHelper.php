<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand;

use App\Slack\Message\Layout;
use App\Slack\SlashCommand\Sharep\SharepCommandProcessor;
use JMS\Serializer\SerializerInterface;

class CommandHelper
{
    /** @var SharepCommandProcessor */
    private $sharepCommandProcessor;
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SharepCommandProcessor $sharepCommandProcessor, SerializerInterface $serializer)
    {
        $this->sharepCommandProcessor = $sharepCommandProcessor;
        $this->serializer = $serializer;
    }

    public function handleWebhook(array $data): Layout
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        /** @var CommandData $commandData */
        $commandData = $this->serializer->deserialize($json, CommandData::class, 'json');

        if (SharepCommandProcessor::COMMAND === $commandData->command) {
            return $this->sharepCommandProcessor->process($commandData);
        }

        throw new \InvalidArgumentException(sprintf('Unknown command "%s"', $commandData->command));
    }
}
