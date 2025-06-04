<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\DefineType;
use PhpStaticAnalysis\Attributes\ImportType;
use PHPUnit\Framework\TestCase;

#[ImportType(UserAddress: User::class)]
#[ImportType('UserName from User')]
#[ImportType(
    StringArray: 'User',
    IntArray: 'User',
)]
class ImportTypeTest extends TestCase
{
    public function testClassTypes(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            0 => 'UserName from User',
            'UserAddress' => 'User',
            'StringArray' => 'User',
            'IntArray' => 'User',
        ], self::getPropertiesFromReflection($reflection));
    }

    public static function getPropertiesFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $properties = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === ImportType::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof ImportType);
                $properties = array_merge($properties, $instance->from);
            }
        }

        return $properties;
    }
}

#[DefineType(UserAddress: 'array{street: string, city: string, zip: string}')]
#[DefineType('UserName array{firstName: string, lastName: string}')]
#[DefineType(
    StringArray: 'string[]',
    IntArray: 'int[]',
)]
class User
{
}
