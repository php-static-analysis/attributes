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
        $instances = AttributeHelper::getInstances($reflection, RequireImplements::class);
        $implements = [];
        foreach ($instances as $instance) {
            $implements = array_merge($implements, $instance->interfaces);
        }

        return $implements;
    }
}

#[RequireImplements(RequireTestInterface::class)]
#[RequireImplements(
    RequireTestInterface2::class,
    RequireTestInterface3::class
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
