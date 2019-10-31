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
use App\Slack\PredefinedMessage\ErrorMessage;
use App\Slack\PredefinedMessage\NotRecognizedUserMessage;
use App\Slack\SlashCommand\Data\CommandData;
use App\Slack\SlashCommand\Sharep\SharepCommandProcessor;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;

class CommandHelper
{
    /** @var SharepCommandProcessor */
    private $sharepCommandProcessor;
    /** @var ErrorMessage */
    private $errorMessage;
    /** @var NotRecognizedUserMessage */
    private $notRecognizedUserMessage;
    /** @var SerializerInterface */
    private $serializer;
    /** @var MemberRepository */
    private $memberRepository;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        SharepCommandProcessor $sharepCommandProcessor,
        ErrorMessage $errorMessage,
        NotRecognizedUserMessage $notRecognizedUserMessage,
        SerializerInterface $serializer,
        MemberRepository $memberRepository,
        LoggerInterface $logger
    ) {
        $this->sharepCommandProcessor = $sharepCommandProcessor;
        $this->errorMessage = $errorMessage;
        $this->notRecognizedUserMessage = $notRecognizedUserMessage;
        $this->serializer = $serializer;
        $this->memberRepository = $memberRepository;
        $this->logger = $logger;
    }

    public function handleWebhook(array $data): Layout
    {
        try {
            $message = null;
            $commandData = $this->calculateCommandData($data);

            if (!$this->memberRepository->findOneBySlackUserId($commandData->userId) instanceof Member) {
                return $this->notRecognizedUserMessage->generate();
            }

            if (SharepCommandProcessor::COMMAND === $commandData->command) {
                $message = $this->sharepCommandProcessor->process($commandData);
            }

            if (!$message instanceof Layout) {
                $message = $this->errorMessage->generate();
            }
        } catch (\Throwable $e) {
            $this->logger->error($e);
            $message = $this->errorMessage->generate();
        }

        return $message;
    }

    private function calculateCommandData(array $data): CommandData
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        /** @var CommandData $commandData */
        $commandData = $this->serializer->deserialize($json, CommandData::class, 'json');

        return $commandData;
    }
}
