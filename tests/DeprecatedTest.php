<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Deprecated;
use PHPUnit\Framework\TestCase;

#[Deprecated]
class DeprecatedTest extends TestCase
{
    #[Deprecated]
    public string $property;

    public function testDeprecatedProperty(): void
    {
        $reflection = new ReflectionProperty($this, 'property');
        $this->assertTrue(self::getDeprecatedFromReflection($reflection));
    }

    public function testClassDeprecated(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertTrue(self::getDeprecatedFromReflection($reflection));
    }

    public function testTraitDeprecated(): void
    {
        $reflection = new ReflectionClass(DeprecatedTestTrait::class);
        $this->assertTrue(self::getDeprecatedFromReflection($reflection));
    }

    public function testInterfaceDeprecated(): void
    {
        $reflection = new ReflectionClass(DeprecatedTestInterface::class);
        $this->assertTrue(self::getDeprecatedFromReflection($reflection));
    }

    public function testMethodDeprecated(): void
    {
        $this->assertTrue($this->methodDeprecated());
    }

    public function testInvalidTypeMethodDeprecated(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodDeprecated();
        } catch (Error $e) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testFunctionDeprecated(): void
    {
        $this->assertTrue(functionDeprecated());
    }

    #[Deprecated]
    private function methodDeprecated(): bool
    {
        return $this->getDeprecated(__FUNCTION__);
    }

    #[Deprecated]
    #[Deprecated]
    private function invalidTypeMethodDeprecated(): bool
    {
        return $this->getDeprecated(__FUNCTION__);
    }

    private function getDeprecated(string $methodName): bool
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getDeprecatedFromReflection($reflection);
    }

    public static function getDeprecatedFromReflection(
        ReflectionMethod | ReflectionFunction | ReflectionClass | ReflectionProperty $reflection
    ): bool {
        $attributes = $reflection->getAttributes();
        $deprecated = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Deprecated::class) {
                $attribute->newInstance();
                $deprecated = true;
            }
        }

        return $deprecated;
    }
}

#[Deprecated]
trait DeprecatedTestTrait
{
}

#[Deprecated]
interface DeprecatedTestInterface
{
}

#[Deprecated]
function functionDeprecated(): bool
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return DeprecatedTest::getDeprecatedFromReflection($reflection);
}
