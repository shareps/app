<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Entity\Traits;

use PHPUnit\Framework\TestCase;

class PropertyActiveStrictTraitTest extends TestCase
{
    /**
     * @var object|null
     */
    private $entity;

    public function setUp(): void
    {
        $this->entity = new DummyEntity();
    }

    public function test_PropertyActiveStrictTestTrait(): void
    {
        $this->assertFalse($this->entity->isActive());
        $this->assertSame($this->entity, $this->entity->setActive(true));
        $this->assertTrue($this->entity->isActive());
    }
}
