<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand\Sharep;

use App\Slack\MessageBuilder\Block\SectionBlock;
use App\Slack\MessageBuilder\Layout;
use App\Slack\MessageBuilder\MessageFactory;
use App\Slack\SlashCommand\CommandData;
use App\Slack\SlashCommand\TaskProcessorInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ReleaseTaskProcessor implements TaskProcessorInterface
{
    /** @var MessageBusInterface */
    private $messageBus;
    /** @var MessageFactory */
    private $messageFactory;

    public function __construct(MessageBusInterface $messageBus, MessageFactory $messageFactory)
    {
        $this->messageBus = $messageBus;
        $this->messageFactory = $messageFactory;
    }

    public function support(CommandData $commandData): bool
    {
        return (bool) preg_match("/^release\s?/i", $commandData->text);
    }

    public function process(CommandData $commandData): Layout
    {
        $mf = $this->messageFactory;

        return $mf->layout(
            $mf->blockSection(
                $mf->elementPlainText('Please select date'),
                $mf->elementDatePicker('datepicker')
            )
        );
    }

    public function getBlockHelp(): SectionBlock
    {
        $mf = $this->messageFactory;

        return $mf->blockSection($mf->elementPlainText($this->getTextHelp()));
    }

    public function getTextHelp(): string
    {
        return 'release 2111-11-11|today|tomorrow';
    }
}
