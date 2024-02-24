<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\RequireImplements;
use PHPUnit\Framework\TestCase;

class RequireImplementsTest extends TestCase implements RequireTestInterface, RequireTestInterface2, RequireTestInterface3
{
    use RequireInterfaceTrait;

    public function testClassRequireImplements(): void
    {
        $reflection = new ReflectionClass(RequireInterfaceTrait::class);
        $this->assertEquals([
            'RequireTestInterface',
            'RequireTestInterface2',
            'RequireTestInterface3',
        ], self::getRequireImplementssFromReflection($reflection));
    }

    public static function getRequireImplementssFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $implements = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === RequireImplements::class) {
                $attribute->newInstance();
                $implements = array_merge($implements, $attribute->getArguments());
            }
        }

        return $implements;
    }
}

#[RequireImplements('RequireTestInterface')]
#[RequireImplements(
    'RequireTestInterface2',
    'RequireTestInterface3'
)]
trait RequireInterfaceTrait
{
}

interface RequireTestInterface
{
}

interface RequireTestInterface2
{
}

interface RequireTestInterface3
{
}
