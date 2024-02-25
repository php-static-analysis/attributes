<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Impure;
use PHPUnit\Framework\TestCase;

class ImpureTest extends TestCase
{
    public function testImpureMethod(): void
    {
        $this->assertTrue($this->methodImpure());
    }

    public function testImpureFunction(): void
    {
        $this->assertTrue(functionImpure());
    }

    #[Impure]
    private function methodImpure(): bool
    {
        return $this->getImpure(__FUNCTION__);
    }

    private function getImpure(string $methodName): bool
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getImpureFromReflection($reflection);
    }

    public static function getImpureFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): bool {
        $attributes = $reflection->getAttributes();
        $impure = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Impure::class) {
                $attribute->newInstance();
                $impure = true;
            }
        }

        return $impure;
    }
}

#[Impure]
function functionImpure(): bool
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return ImpureTest::getImpureFromReflection($reflection);
}
