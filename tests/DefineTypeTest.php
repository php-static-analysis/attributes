<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\DefineType;
use PHPUnit\Framework\TestCase;

#[DefineType(UserAddress: 'array{street: string, city: string, zip: string}')]
#[DefineType('UserName array{firstName: string, lastName: string}')]
#[DefineType(
    StringArray: 'string[]',
    IntArray: 'int[]',
)]
class DefineTypeTest extends TestCase
{
    public function testClassTypes(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            0 => 'UserName array{firstName: string, lastName: string}',
            'UserAddress' => 'array{street: string, city: string, zip: string}',
            'StringArray' => 'string[]',
            'IntArray' => 'int[]',
        ], self::getPropertiesFromReflection($reflection));
    }

    public static function getPropertiesFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $properties = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === DefineType::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof DefineType);
                $properties = array_merge($properties, $instance->types);
            }
        }

        return $properties;
    }
}
