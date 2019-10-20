<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\Message\Block;

use App\Slack\Message\Element\SectionBlockAccessoryInterface;
use App\Slack\Message\Element\TextElementInterface;
use App\Slack\Message\Enum\MessageTypeEnum;
use App\Slack\Message\MessageJsonSerializeTrait;

class SectionBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var TextElementInterface|null */
    private $text;
    /** @var SectionBlockAccessoryInterface|null */
    private $accessory;
    /** @var array|TextElementInterface[] */
    private $fields;

    public function __construct(TextElementInterface $text, SectionBlockAccessoryInterface $accessory = null, TextElementInterface ...$fields)
    {
        $this->type = MessageTypeEnum::BLOCK_SECTION;
        $this->text = $text;
        $this->accessory = $accessory;
        $this->fields = $fields;
    }
}
