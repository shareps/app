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
use App\Slack\SlashCommand\Sharep\SharepCommandProcessor;
use JMS\Serializer\SerializerInterface;

class CommandHelper
{
    /** @var SharepCommandProcessor */
    private $sharepCommandProcessor;
    /** @var SerializerInterface */
    private $serializer;
    /** @var MemberRepository */
    private $memberRepository;

    public function __construct(
        SharepCommandProcessor $sharepCommandProcessor,
        SerializerInterface $serializer,
        MemberRepository $memberRepository
    ) {
        $this->sharepCommandProcessor = $sharepCommandProcessor;
        $this->serializer = $serializer;
        $this->memberRepository = $memberRepository;
    }

    public function handleWebhook(array $data): Layout
    {
        $commandData = $this->calculateCommandData($data);

        $member = $this->memberRepository->findOneBySlackUserId($commandData->userId);
        if (!$member instanceof Member) {
        }

        if (SharepCommandProcessor::COMMAND === $commandData->command) {
            return $this->sharepCommandProcessor->process($commandData);
        }

        throw new \InvalidArgumentException(sprintf('Unknown command "%s"', $commandData->command));
    }

    private function calculateCommandData(array $data): CommandData
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        /** @var CommandData $commandData */
        $commandData = $this->serializer->deserialize($json, CommandData::class, 'json');

        return $commandData;
    }
}
