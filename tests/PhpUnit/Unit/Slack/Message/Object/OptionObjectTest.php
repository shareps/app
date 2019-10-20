<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Slack\Message\Object;

use App\Slack\Message\Object\OptionObject;
use PHPUnit\Framework\TestCase;

class OptionObjectTest extends TestCase
{
    public function testFull(): void
    {
        $object = new OptionObject(
            'TestText',
            'TestValue',
            'TestUrl'
        );
        $result = [
            'text' => [
                'type' => 'plain_text',
                'text' => 'TestText',
                'emoji' => false,
            ],
            'value' => 'TestValue',
            'url' => 'TestUrl',
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }

    public function testWithoutUrl(): void
    {
        $object = new OptionObject(
            'TestText',
            'TestValue'
        );
        $result = [
            'text' => [
                'type' => 'plain_text',
                'text' => 'TestText',
                'emoji' => false,
            ],
            'value' => 'TestValue',
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }
}
