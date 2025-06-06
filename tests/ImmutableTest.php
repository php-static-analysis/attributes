<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Immutable;
use PHPUnit\Framework\TestCase;

#[Immutable]
class ImmutableTest extends TestCase
{
    public function testClassImmutable(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertTrue(self::getImmutableFromReflection($reflection));
    }

    public function testTraitImmutable(): void
    {
        $reflection = new ReflectionClass(ImmutableTestTrait::class);
        $this->assertTrue(self::getImmutableFromReflection($reflection));
    }

    public function testInterfaceImmutable(): void
    {
        $reflection = new ReflectionClass(ImmutableTestInterface::class);
        $this->assertTrue(self::getImmutableFromReflection($reflection));
    }

    public static function getImmutableFromReflection(
        ReflectionClass $reflection
    ): bool {
        return AttributeHelper::getInstances($reflection, Immutable::class) !== [];
    }
}

#[Immutable]
trait ImmutableTestTrait
{
}

#[Immutable]
interface ImmutableTestInterface
{
}

class ImmutableClass
{
    use ImmutableTestTrait;
}
