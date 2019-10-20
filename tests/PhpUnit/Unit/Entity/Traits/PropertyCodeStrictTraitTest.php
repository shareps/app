<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Entity\Traits;

use PHPUnit\Framework\TestCase;

class PropertyCodeStrictTraitTest extends TestCase
{
    /**
     * @var object|null
     */
    private $entity;

    public function setUp(): void
    {
        $this->entity = new DummyEntity();
    }

    public function test_PropertyCodeStrictTestTrait(): void
    {
        $this->assertSame('', $this->entity->getCode());
        $this->assertSame($this->entity, $this->entity->setCode(' TesT '));
        $this->assertSame('TEST', $this->entity->getCode());

        $e = null;
        try {
            $this->entity->setCode(' TesT ');
        } catch (\Throwable $e) {
        }
        $this->assertInstanceOf(\Throwable::class, $e);
    }
}
