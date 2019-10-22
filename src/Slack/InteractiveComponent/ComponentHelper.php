<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\InteractiveComponent;

use App\Slack\MessageBuilder\Layout;
use JMS\Serializer\SerializerInterface;

class ComponentHelper
{
    /** @var SerializerInterface */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function handleWebhook(array $data): Layout
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR);
        /** @var ComponentData $componentData */
        $componentData = $this->serializer->deserialize($json, ComponentData::class, 'json');

        throw new \InvalidArgumentException(sprintf('Unknown component "%s"', $componentData->type));
    }
}
