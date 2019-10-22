<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Element;

use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class ImageElement implements SectionBlockAccessoryInterface, ContextBlockElementInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $imageUrl;
    /** @var string */
    private $altText;

    public function __construct(string $imageUrl, string $altText)
    {
        if (\strlen($imageUrl) > 3000) {
            throw new \InvalidArgumentException('$imageUrl too long!');
        }
        if (\strlen($altText) > 2000) {
            throw new \InvalidArgumentException('$altText too long!');
        }

        $this->type = MessageTypeEnum::ELEMENT_IMAGE;
        $this->imageUrl = $imageUrl;
        $this->altText = $altText;
    }
}
