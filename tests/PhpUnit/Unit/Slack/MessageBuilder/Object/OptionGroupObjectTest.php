<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Slack\MessageBuilder\Object;

use App\Slack\MessageBuilder\Object\OptionGroupObject;
use App\Slack\MessageBuilder\Object\OptionObject;
use PHPUnit\Framework\TestCase;

class OptionGroupObjectTest extends TestCase
{
    public function testFull(): void
    {
        $object = new OptionGroupObject(
            'TestLabel',
            $object = new OptionObject(
                'TestText',
                'TestValue',
                'TestUrl'
            )
        );
        $result = [
            'label' => [
                'type' => 'plain_text',
                'text' => 'TestLabel',
                'emoji' => false,
            ],
            'options' => [
                [
                    'text' => [
                        'type' => 'plain_text',
                        'text' => 'TestText',
                        'emoji' => false,
                    ],
                    'value' => 'TestValue',
                    'url' => 'TestUrl',
                ],
            ],
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }
}
