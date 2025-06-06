<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Property;
use PHPUnit\Framework\TestCase;

#[Property(name: 'string')]
#[Property('int $age')]
#[Property(
    index1: 'string[]',
    index2: 'string[]',
)]
class PropertyTest extends TestCase
{
    #[Property('string')]
    public string $property;

    public function testClassProperties(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            0 => 'int $age',
            'name' => 'string',
            'index1' => 'string[]',
            'index2' => 'string[]',
        ], self::getPropertiesFromReflection($reflection));
    }

    public function testPropertyProperties(): void
    {
        $reflection = new ReflectionProperty($this, 'property');
        $this->assertEquals(['string'], self::getPropertiesFromReflection($reflection));
    }

    public static function getPropertiesFromReflection(
        ReflectionProperty | ReflectionClass $reflection
    ): array {
        $instances = AttributeHelper::getInstances($reflection, Property::class);
        $properties = [];
        foreach ($instances as $instance) {
            $properties = array_merge($properties, $instance->properties);
        }

        return $properties;
    }
}
