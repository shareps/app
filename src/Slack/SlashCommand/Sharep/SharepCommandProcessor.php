<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand\Sharep;

use App\Slack\MessageBuilder\Layout;
use App\Slack\PredefinedMessage\SharepHelpMessage;
use App\Slack\SlashCommand\CommandProcessorInterface;
use App\Slack\SlashCommand\Data\CommandData;
use App\Slack\SlashCommand\TaskProcessorInterface;

class SharepCommandProcessor implements CommandProcessorInterface
{
    public const COMMAND = '/sharep';
    /** @var SharepReleaseTaskProcessor */
    private $releaseTaskProcessor;
    /** @var SharepHelpMessage */
    private $sharepHelpMessage;

    public function __construct(SharepReleaseTaskProcessor $releaseTaskProcessor, SharepHelpMessage $sharepHelpMessage)
    {
        $this->releaseTaskProcessor = $releaseTaskProcessor;
        $this->sharepHelpMessage = $sharepHelpMessage;
    }

    public function process(CommandData $commandData): Layout
    {
        /** @var TaskProcessorInterface $taskProcessor */
        foreach ($this->getTaskProcessors() as $taskProcessor) {
            if ($taskProcessor->supports($commandData)) {
                return $taskProcessor->process($commandData);
            }
        }

        return $this->sharepHelpMessage->generate();
    }

    private function getTaskProcessors(): array
    {
        $taskProcessors = [
            $this->releaseTaskProcessor,
        ];

        return $taskProcessors;
    }
}
