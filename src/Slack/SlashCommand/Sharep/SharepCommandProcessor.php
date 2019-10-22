<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand\Sharep;

use App\Slack\MessageBuilder\Layout;
use App\Slack\MessageBuilder\MessageFactory;
use App\Slack\SlashCommand\CommandData;
use App\Slack\SlashCommand\CommandProcessorInterface;
use App\Slack\SlashCommand\TaskProcessorInterface;

class SharepCommandProcessor implements CommandProcessorInterface
{
    public const COMMAND = '/sharep';
    /** @var ReleaseTaskProcessor */
    private $releaseTaskProcessor;
    /** @var MessageFactory */
    private $messageFactory;

    public function __construct(ReleaseTaskProcessor $releaseTaskProcessor, MessageFactory $messageFactory)
    {
        $this->releaseTaskProcessor = $releaseTaskProcessor;
        $this->messageFactory = $messageFactory;
    }

    public function process(CommandData $commandData): Layout
    {
        /** @var TaskProcessorInterface $taskProcessor */
        foreach ($this->getTaskProcessors() as $taskProcessor) {
            if ($taskProcessor->support($commandData)) {
                return $taskProcessor->process($commandData);
            }
        }

        return $this->createLayoutNotRecognized();
    }

    private function createLayoutNotRecognized(): Layout
    {
        $mf = $this->messageFactory;
        $blocks[] = $mf->blockSection($mf->elementPlainText('Command content not recognized'));
        /** @var TaskProcessorInterface $taskProcessor */
        foreach ($this->getTaskProcessors() as $taskProcessor) {
            $taskProcessor->getBlockHelp();
        }

        return $mf->layout(
            $mf->blockSection($mf->elementPlainText('Command content not recognized')),
        );
    }

    private function getTaskProcessors(): array
    {
        $taskProcessors = [
            $this->releaseTaskProcessor,
        ];

        return $taskProcessors;
    }
}
