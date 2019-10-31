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
use App\Slack\SlashCommand\Data\CommandData;
use App\Slack\SlashCommand\TaskProcessorInterface;

class SharepTakeTaskProcessor implements TaskProcessorInterface
{
    /** @var MessageFactory */
    private $messageFactory;

    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    public function supports(CommandData $commandData): bool
    {
        return (bool) preg_match("/^take\s?/i", $commandData->text);
    }

    public function process(CommandData $commandData): Layout
    {
        $mf = $this->messageFactory;

        return $mf->layout(
            $mf->blockSection(
                $mf->elementPlainText('Please select dates to take'),
                $mf->elementMultiSelectStaticGroup(
                    'Select dates',
                    'sharep-take-multiselect-dates',
                    null,
                    null,
                    $mf->objectOptionGroup(
                        'Week 41',
                        $mf->objectOption('Mo 2019-11-11', '2019-11-11'),
                        $mf->objectOption('Tu 2019-11-12', '2019-11-12'),
                        $mf->objectOption('We 2019-11-13', '2019-11-13'),
                        $mf->objectOption('Th 2019-11-14', '2019-11-14'),
                        $mf->objectOption('Fr 2019-11-15', '2019-11-15'),
                    ),
                    $mf->objectOptionGroup(
                        'Week 42',
                        $mf->objectOption('Mo 2019-11-18', '2019-11-18'),
                        $mf->objectOption('Tu 2019-11-19', '2019-11-19'),
                        $mf->objectOption('We 2019-11-20', '2019-11-20'),
                        $mf->objectOption('Th 2019-11-21', '2019-11-21'),
                        $mf->objectOption('Fr 2019-11-22', '2019-11-22'),
                    )
                )
            ),
            $mf->blockActions(
                $mf->elementPlainText(
                    'Take place for released date'
                ),
                $mf->elementButton(
                    'Mo 2019-11-11',
                    'sharep-take-button-date',
                    null,
                    null,
                    '2019-11-11'
                ),
                $mf->elementButton(
                    'Tu 2019-11-12',
                    'sharep-take-button-date',
                    null,
                    null,
                    '2019-11-12'
                )
            )
        );
    }
}
