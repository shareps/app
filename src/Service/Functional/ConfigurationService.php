<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\Service\Functional;

use App\Enum\Functional\PermissionEnum;
use App\Enum\Functional\RoleEnum;

class ConfigurationService
{
    /** @var array */
    private $appConfiguration;

    public function __construct(array $appConfiguration)
    {
        $this->appConfiguration = $appConfiguration;
    }

    public function getPermissions(): array
    {
        return $this->appConfiguration['permissions'];
    }

    public function hasPermissionBoolean(
        PermissionEnum $permissionEnum,
        RoleEnum $requesterRoleEnum
    ): bool {
        return $this->getPermissions()[$permissionEnum->getValue()][$requesterRoleEnum->getValue()] ?? false;
    }

    public function hasPermissionRole(
        PermissionEnum $permissionEnum,
        RoleEnum $requesterRoleEnum,
        RoleEnum $subjectRoleEnum
    ): bool {
        $roles = $this->getPermissions()[$permissionEnum->getValue()][$requesterRoleEnum->getValue()]['roles'] ?? [];

        return \in_array($subjectRoleEnum->getValue(), $roles, true);
    }

    public function hasPermissionSelfOnly(
        PermissionEnum $permissionEnum,
        RoleEnum $requesterRoleEnum
    ): bool {
        return $this->getPermissions()[$permissionEnum->getValue()][$requesterRoleEnum->getValue()]['self_only'] ?? false;
    }
}
