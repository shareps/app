<?php

/** @noinspection UnusedConstructorDependenciesInspection */

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder\Block;

use App\Slack\MessageBuilder\Element\SectionBlockElementInterface;
use App\Slack\MessageBuilder\Element\TextElementInterface;
use App\Slack\MessageBuilder\Enum\MessageTypeEnum;
use App\Slack\MessageBuilder\MessageJsonSerializeTrait;

class SectionBlock implements BlockInterface
{
    use MessageJsonSerializeTrait;

    /** @var string */
    private $type;
    /** @var TextElementInterface|null */
    private $text;
    /** @var SectionBlockElementInterface|null */
    private $accessory;
    /** @var array|TextElementInterface[] */
    private $fields;

    public function __construct(TextElementInterface $text, SectionBlockElementInterface $accessory = null, TextElementInterface ...$fields)
    {
        $this->type = MessageTypeEnum::BLOCK_SECTION;
        $this->text = $text;
        $this->accessory = $accessory;
        $this->fields = $fields;
    }
}
