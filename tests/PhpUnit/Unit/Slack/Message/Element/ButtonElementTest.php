<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Slack\Message\Element;

use App\Slack\Message\Element\ButtonElement;
use App\Slack\Message\Element\MarkdownTextElement;
use App\Slack\Message\Enum\ButtonStyleEnum;
use App\Slack\Message\Object\ConfirmationDialogObject;
use PHPUnit\Framework\TestCase;

class ButtonElementTest extends TestCase
{
    public function testFull(): void
    {
        $object = new ButtonElement(
            'TestText',
            'TestActionId',
            ButtonStyleEnum::PRIMARY(),
            new ConfirmationDialogObject(
                'TestTitle',
                new MarkdownTextElement('TestText'),
                'TestConfirm',
                'TestDeny'
            ),
            'TestValue',
            'TestUrl'
        );
        $result = [
            'type' => 'button',
            'text' => [
                'type' => 'plain_text',
                'text' => 'TestText',
                'emoji' => false,
            ],
            'action_id' => 'TestActionId',
            'style' => 'primary',
            'confirm' => [
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
            ],
            'value' => 'TestValue',
            'url' => 'TestUrl',
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }
}
