<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand;

use App\Entity\Parking\Member;
use App\Repository\Entity\Parking\MemberRepository;
use App\Slack\MessageBuilder\Layout;
use App\Slack\SlashCommand\Sharep\NotRecognizedTaskProcessor;
use App\Slack\SlashCommand\Sharep\NotRecognizedUserProcessor;
use App\Slack\SlashCommand\Sharep\SharepCommandProcessor;
use JMS\Serializer\SerializerInterface;

class CommandHelper
{
    /** @var SharepCommandProcessor */
    private $sharepCommandProcessor;
    /** @var NotRecognizedTaskProcessor */
    private $notRecognizedTaskProcessor;
    /** @var NotRecognizedUserProcessor */
    private $notRecognizedUserProcessor;
    /** @var SerializerInterface */
    private $serializer;
    /** @var MemberRepository */
    private $memberRepository;

    public function __construct(
        SharepCommandProcessor $sharepCommandProcessor,
        NotRecognizedTaskProcessor $notRecognizedTaskProcessor,
        NotRecognizedUserProcessor $notRecognizedUserProcessor,
        SerializerInterface $serializer,
        MemberRepository $memberRepository
    ) {
        $this->sharepCommandProcessor = $sharepCommandProcessor;
        $this->notRecognizedTaskProcessor = $notRecognizedTaskProcessor;
        $this->notRecognizedUserProcessor = $notRecognizedUserProcessor;
        $this->serializer = $serializer;
        $this->memberRepository = $memberRepository;
    }

    public function handleWebhook(array $data): Layout
    {
        $commandData = $this->calculateCommandData($data);

        $member = $this->memberRepository->findOneBySlackUserId($commandData->userId);
        if (!$member instanceof Member) {
            return $this->notRecognizedUserProcessor->process($commandData);
        }

        if (SharepCommandProcessor::COMMAND === $commandData->command) {
            return $this->sharepCommandProcessor->process($commandData);
        }

        return $this->notRecognizedTaskProcessor->process($commandData);
    }

    private function calculateCommandData(array $data): CommandData
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        /** @var CommandData $commandData */
        $commandData = $this->serializer->deserialize($json, CommandData::class, 'json');

        return $commandData;
    }
}
