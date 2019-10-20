<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Entity\Traits;

use PHPUnit\Framework\TestCase;

class PropertyIdGeneratedTraitTest extends TestCase
{
    /**
     * @var object|null
     */
    private $entity;

    public function setUp(): void
    {
        $this->entity = new DummyEntity();
    }

    public function test_PropertyIdGeneratedTestTrait(): void
    {
        $this->assertInternalType('string', $this->entity->getId());
    }
}
