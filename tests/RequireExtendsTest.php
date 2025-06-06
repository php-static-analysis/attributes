<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\RequireExtends;
use PHPUnit\Framework\TestCase;

class RequireExtendsTest extends TestCase
{
    public function testClassRequireExtends(): void
    {
        $reflection = new ReflectionClass(RequireMyTrait::class);
        $this->assertEquals('RequireParentClass', self::getRequireExtendssFromReflection($reflection));
    }

    public static function getRequireExtendssFromReflection(
        ReflectionClass $reflection
    ): string {
        $instances = AttributeHelper::getInstances($reflection, RequireExtends::class);
        $extends = '';
        foreach ($instances as $instance) {
            $extends = $instance->class;
        }

        return $extends;
    }
}

class RequireParentClass
{
}

#[RequireExtends(RequireParentClass::class)]
trait RequireMyTrait
{
}

class RequireChildClass extends RequireParentClass
{
    use RequireMyTrait;
}
