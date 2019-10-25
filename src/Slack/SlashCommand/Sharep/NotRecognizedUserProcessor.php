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
use App\Slack\SlashCommand\TaskProcessorInterface;

class NotRecognizedUserProcessor implements TaskProcessorInterface
{
    /** @var MessageFactory */
    private $messageFactory;

    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    public function support(CommandData $commandData): bool
    {
        return true;
    }

    public function process(CommandData $commandData): Layout
    {
        $mf = $this->messageFactory;

        return $mf->layout(
            $mf->blockSection(
                $mf->elementPlainText('I do not know you!'),
            )
        );
    }
}
