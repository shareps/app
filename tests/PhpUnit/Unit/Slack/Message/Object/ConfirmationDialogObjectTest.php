<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Slack\Message\Object;

use App\Slack\Message\Element\MarkdownTextElement;
use App\Slack\Message\Object\ConfirmationDialogObject;
use PHPUnit\Framework\TestCase;

class ConfirmationDialogObjectTest extends TestCase
{
    public function testFull(): void
    {
        $object = new ConfirmationDialogObject(
            'TestTitle',
            new MarkdownTextElement('TestText'),
            'TestConfirm',
            'TestDeny'
        );
        $result = [
            'title' => [
                'type' => 'plain_text',
                'text' => 'TestTitle',
                'emoji' => false,
            ],
            'text' => [
                'type' => 'mrkdwn',
                'text' => 'TestText',
                'verbatim' => false,
            ],
            'confirm' => [
                'type' => 'plain_text',
                'text' => 'TestConfirm',
                'emoji' => false,
            ],
            'deny' => [
                'type' => 'plain_text',
                'text' => 'TestDeny',
                'emoji' => false,
            ],
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }
}
