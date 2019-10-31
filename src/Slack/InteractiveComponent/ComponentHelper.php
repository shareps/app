<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent;

use App\Slack\MessageBuilder\Layout;
use App\Slack\PredefinedMessage\SharepHelpMessage;
use JMS\Serializer\SerializerInterface;

class ComponentHelper
{
    /** @var SerializerInterface */
    private $serializer;
    /** @var SharepHelpMessage */
    private $sharepHelpMessage;

    public function __construct(SerializerInterface $serializer, SharepHelpMessage $sharepHelpMessage)
    {
        $this->serializer = $serializer;
        $this->sharepHelpMessage = $sharepHelpMessage;
    }

    public function handleWebhook(array $data): Layout
    {
        return $this->sharepHelpMessage->generate();
    }
}
