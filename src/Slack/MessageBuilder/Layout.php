<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\MessageBuilder;

use App\Slack\MessageBuilder\Block\BlockInterface;

class Layout implements MessageInterface
{
    /** @var array|BlockInterface[] */
    private $blocks;

    public function __construct(BlockInterface ...$blocks)
    {
        $this->blocks = $blocks;
    }

    public function jsonSerialize(): array
    {
        $jsonData = [];

        foreach ($this->blocks as $block) {
            $jsonData[] = $block->jsonSerialize();
        }

        return ['blocks' => $jsonData];
    }
}
