<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Unit\Entity\Parking;

use App\Entity\Access\User;
use App\Entity\EntityInterface;
use App\Entity\Parking\Member;
use App\Enum\Functional\RoleEnum;
use AppTests\PhpUnit\Traits\GetterSetterTestTrait;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class MemberTest extends TestCase
{
    use GetterSetterTestTrait;

    /**
     * @var Member|null
     */
    private $entity;

    public function setUp(): void
    {
        $this->entity = new Member(' Test ', RoleEnum::MEMBER(), new User());
    }

    public function test_instanceOf(): void
    {
        $this->assertInstanceOf(Member::class, $this->entity);
        $this->assertInstanceOf(EntityInterface::class, $this->entity);
    }

    protected function getGetterSetterData(): array
    {
        return [
            'id' => [null, 'getId', '', 'uuid', []],
            'user' => [null, 'getUser', User::class, 'instanceOf', []],
            'role' => ['setRole', 'getRole', RoleEnum::class, 'instanceOf', []],
            'name' => [null, 'getName', 'Test', 'string', []],
            'points' => ['setPoints', 'getPoints', 0, 'integer', [[100, 100], [0, 0]]],
            'memberships' => [null, 'getMemberships', ArrayCollection::class, 'instanceOf', []],
            'memberNeeds' => [null, 'getMemberNeeds', ArrayCollection::class, 'instanceOf', []],
        ];
    }

    protected function getObject(): object
    {
        return $this->entity;
    }
}
