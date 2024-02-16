<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\PropertyRead;
use PHPUnit\Framework\TestCase;

#[PropertyRead(name: 'string')]
#[PropertyRead('int $age')]
#[PropertyRead(
    index1: 'string[]',
    index2: 'string[]',
)]
class PropertyReadTest extends TestCase
{
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

    public static function getPropertiesFromReflection(
        ReflectionProperty | ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $properties = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === PropertyRead::class) {
                $attribute->newInstance();
                $properties = array_merge($properties, $attribute->getArguments());
            }
        }

        return $properties;
    }
}
