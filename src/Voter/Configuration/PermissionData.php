<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Voter\Configuration;

class PermissionData
{
    /** @var string */
    private $type;
    /** @var string */
    private $class;
    /** @var bool */
    private $isNullable;

    public function __construct(string $roleValue, string $class, bool $isNullable)
    {
        $this->type = $roleValue;
        $this->class = $class;
        $this->isNullable = $isNullable;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function isNullable(): bool
    {
        return $this->isNullable;
    }
}
