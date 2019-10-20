<?php

declare(strict_types=1);

/*
 * This file is part of the zibios/sharep.
 *
 * (c) Zbigniew Ślązak
 */

namespace AppTests\PhpUnit\Traits;

use PHPUnit\Framework\TestCase;

/**
 * @mixin TestCase
 */
trait GetterSetterTestTrait
{
    protected function assertGetterSetter(): void
    {
        $this->assertAllPropertiesTested($this->getObject(), $this->getGetterSetterData());
        $this->assertAllGettersSetters($this->getObject(), $this->getGetterSetterData());
    }

    abstract protected function getGetterSetterData(): array;

    abstract protected function getObject(): object;

    protected function assertAllPropertiesTested(object $object, array $propertiesConfiguration): void
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $this->assertArrayHasKey($property->getName(), $propertiesConfiguration);
        }

        foreach ($propertiesConfiguration as $propertyName => $propertyConfiguration) {
            $this->assertTrue($reflection->hasProperty($propertyName));
        }
    }

    protected function assertAllGettersSetters(object $object, array $propertiesConfiguration): void
    {
        foreach ($propertiesConfiguration as $propertyName => $configuration) {
            $this->assertOneGetterSetter(
                $object,
                $propertyName,
                $configuration[0],
                $configuration[1],
                $configuration[2],
                $configuration[3],
                $configuration[4]
            );
        }
    }

    protected function assertOneGetterSetter(
        object $object,
        string $propertyName,
        ?string $setter,
        ?string $getter,
        $default,
        string $type,
        array $examples
    ): void {
        $reflection = new \ReflectionClass(\get_class($object));

        if (null !== $getter) {
            $this->assertTrue($reflection->hasMethod($getter), sprintf('Should has getter "%s"', $getter));

            switch ($type) {
                case 'instanceOf':
                    $this->assertInstanceOf($default, $object->{$getter}());
                    break;
                case 'uuid':
                    $this->assertIsString($object->{$getter}());
                    break;
                default:
                    $this->assertSame($default, $object->{$getter}());
                    break;
            }
        }

        if (null !== $setter) {
            $this->assertTrue($reflection->hasMethod($setter), sprintf('Should has setter "%s"', $setter));
        }

        if (null !== $setter && null !== $getter && 0 < \count($examples)) {
            foreach ($examples as $example) {
                $clonedObject = clone $object;
                $clonedObject->{$setter}($example[0]);
                $this->assertSame($example[1], $clonedObject->{$getter}());
            }
        }
    }
}
