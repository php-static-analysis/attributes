<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Mixin;
use PHPUnit\Framework\TestCase;

class A
{
}

class B
{
}

class C
{
}

#[Mixin(A::class)]
#[Mixin(
    B::class,
    C::class,
)]
class MixinTest extends TestCase
{
    public function testClassMixins(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals(['A', 'B', 'C'], self::getMixinsFromReflection($reflection));
    }

    public static function getMixinsFromReflection(
        ReflectionClass $reflection
    ): array {
        $instances = AttributeHelper::getInstances($reflection, Mixin::class);
        $mixins = [];
        foreach ($instances as $instance) {
            $mixins = array_merge($mixins, $instance->classes);
        }

        return $mixins;
    }
}
