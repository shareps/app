<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\PredefinedMessage;

use App\Slack\MessageBuilder\Enum\ButtonStyleEnum;
use App\Slack\MessageBuilder\Layout;
use App\Slack\MessageBuilder\MessageFactory;

class SharepHelpMessage
{
    /** @var MessageFactory */
    private $messageFactory;

    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    public function generate(): Layout
    {
        $mf = $this->messageFactory;

        return $mf->layout(
            $mf->blockSection(
                $mf->elementPlainText('Please try again, proper commands are:')
            ),
            $mf->blockActions(
                $mf->elementButton('Info', 'sharep-info', ButtonStyleEnum::PRIMARY()),
                $mf->elementButton('Release', 'action-release', ButtonStyleEnum::DANGER()),
            )
        );
    }
}
