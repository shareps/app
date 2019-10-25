<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Slack\SlashCommand;

use App\Slack\MessageBuilder\Layout;

interface TaskProcessorInterface
{
    public function support(CommandData $commandData): bool;

    public function process(CommandData $commandData): Layout;
}
