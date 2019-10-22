<?php

/** @noinspection DuplicatedCode, UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Block;

use App\Slack\MessageBuilder\Element\PlainTextElement;
use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class ImageBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var string */
    private $imageUrl;
    /** @var string */
    private $altText;
    /** @var PlainTextElement|null */
    private $title;

    public function __construct(string $imageUrl, string $altText, string $title = '')
    {
        if (\strlen($imageUrl) > 3000) {
            throw new \InvalidArgumentException('$imageUrl too long!');
        }
        if (\strlen($altText) > 2000) {
            throw new \InvalidArgumentException('$altText too long!');
        }
        if (\strlen($title) > 2000) {
            throw new \InvalidArgumentException('$altText too long!');
        }

        $this->type = MessageTypeEnum::BLOCK_IMAGE;
        $this->imageUrl = $imageUrl;
        $this->altText = $altText;
        if ('' !== $title) {
            $this->title = new PlainTextElement($title);
        }
    }
}
