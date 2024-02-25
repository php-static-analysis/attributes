<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Pure;
use PHPUnit\Framework\TestCase;

class PureTest extends TestCase
{
    public function testPureMethod(): void
    {
        $this->assertTrue($this->methodPure());
    }

    public function testPureFunction(): void
    {
        $this->assertTrue(functionPure());
    }

    #[Pure]
    private function methodPure(): bool
    {
        return $this->getPure(__FUNCTION__);
    }

    private function getPure(string $methodName): bool
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getPureFromReflection($reflection);
    }

    public static function getPureFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): bool {
        $attributes = $reflection->getAttributes();
        $pure = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Pure::class) {
                $attribute->newInstance();
                $pure = true;
            }
        }

        return $pure;
    }
}

#[Pure]
function functionPure(): bool
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return PureTest::getPureFromReflection($reflection);
}
