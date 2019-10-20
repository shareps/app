<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Swagger\Operation;

use App\Swagger\Operation\SlashPathSegmentNameGenerator;
use PHPUnit\Framework\TestCase;

class SlashPathSegmentNameGeneratorTest extends TestCase
{
    /**
     * @var SlashPathSegmentNameGenerator
     */
    public $service;

    public function setUp(): void
    {
        $this->service = new SlashPathSegmentNameGenerator();
    }

    public function dataProviderNames(): array
    {
        return [
            ['FooBar', false, 'foo/bar'],
            ['FooBar', true, 'foo/bars'],
        ];
    }

    /**
     * @dataProvider dataProviderNames
     */
    public function test_getSegmentName(string $name, bool $collection, string $path): void
    {
        $this->assertSame($path, $this->service->getSegmentName($name, $collection));
    }

    public function test_getSegmentName_default(): void
    {
        $this->assertSame('foo/bars', $this->service->getSegmentName('FooBar'));
    }
}
