<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Slack\MessageBuilder\Element;

use App\Slack\MessageBuilder\Element\ImageElement;
use PHPUnit\Framework\TestCase;

class ImageElementTest extends TestCase
{
    public function testFull(): void
    {
        $object = new ImageElement(
            'TestImageUrl',
            'TestAltText',
        );
        $result = [
            'type' => 'image',
            'image_url' => 'TestImageUrl',
            'alt_text' => 'TestAltText',
        ];

        $this->assertSame($result, $object->jsonSerialize());
    }
}
