<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Swagger\Decorator;

use App\Swagger\Decorator\SwaggerDecorator;
use App\Swagger\Operation\SlashPathSegmentNameGenerator;
use PHPUnit\Framework\TestCase;

class SwaggerDecoratorTest extends TestCase
{
    /**
     * @var SlashPathSegmentNameGenerator
     */
    public $service;

    public function setUp(): void
    {
        $this->service = new SwaggerDecorator(new DummyNormalizer());
    }

    public function test_normalizer(): void
    {
        $this->assertSame('test', $this->service->normalize('test'));
        $this->assertArrayHasKey('info', $this->service->normalize([]));
        $this->assertArrayHasKey('title', $this->service->normalize([])['info']);
    }

    public function test_supportsNormalization(): void
    {
        $this->assertTrue($this->service->supportsNormalization(true));
        $this->assertFalse($this->service->supportsNormalization(false));
    }
}
