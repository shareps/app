<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace App\DependencyInjection;

use App\Enum\Functional\PermissionEnum;
use App\Enum\Functional\RoleEnum;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class AppConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('app');

        $treeBuilder->getRootNode()
            ->isRequired()
            ->children()
                ->append($this->addPermissionsNode())
            ->end()
        ;

        return $treeBuilder;
    }

    private function addPermissionsNode(): NodeDefinition
    {
        $treeBuilder = new TreeBuilder('permissions');

        $node = $treeBuilder->getRootNode()
            ->isRequired()
            ->children()

            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_READ))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_UPDATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_DELETE))

            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_BREAK_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_BREAK_READ))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_BREAK_UPDATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_AVAILABILITY_BREAK_DELETE))

            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_MEMBER_READ))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_UPDATE))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_DELETE))

            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_NEED_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_MEMBER_NEED_READ))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_NEED_UPDATE))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBER_NEED_DELETE))

            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBERSHIP_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_MEMBERSHIP_READ))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBERSHIP_UPDATE))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_MEMBERSHIP_DELETE))

            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_RESERVATION_CREATE))
            ->append($this->addPermissionsBoolean(PermissionEnum::PARKING_RESERVATION_READ))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_RESERVATION_UPDATE))
            ->append($this->addPermissionsForRoles(PermissionEnum::PARKING_RESERVATION_DELETE))

            ->end()
        ;

        return $node;
    }

    private function addPermissionsForRoles(string $name): NodeDefinition
    {
        $treeBuilder = new TreeBuilder($name);

        /** @noinspection NullPointerExceptionInspection */
        $node = $treeBuilder->getRootNode()
            ->isRequired()
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->arrayPrototype()
                ->children()
                    ->arrayNode('roles')
                        ->requiresAtLeastOneElement()
                        ->enumPrototype()
                            ->values(RoleEnum::toArray())
                            ->defaultValue([])
                        ->end()
                    ->end()
                    ->booleanNode('self_only')
                        ->defaultValue(false)
                    ->end()
                ->end()
            ->end()
        ;

        return $node;
    }

    private function addPermissionsBoolean(string $name): NodeDefinition
    {
        $treeBuilder = new TreeBuilder($name);

        $node = $treeBuilder->getRootNode()
            ->isRequired()
            ->requiresAtLeastOneElement()
            ->useAttributeAsKey('name')
            ->booleanPrototype()
                    ->isRequired()
                    ->defaultValue(false)
            ->end()
        ;

        return $node;
    }
}
