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
        $attributes = $reflection->getAttributes();
        $mixins = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Mixin::class) {
                $attribute->newInstance();
                $mixins = array_merge($mixins, $attribute->getArguments());
            }
        }

        return $mixins;
    }
}
