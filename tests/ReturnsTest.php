<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Returns;
use PHPUnit\Framework\TestCase;

class ReturnsTest extends TestCase
{
    public function testMethodReturns(): void
    {
        $this->assertEquals('string', $this->methodReturns());
    }

    public function testMethodReturnsArray(): void
    {
        $this->assertEquals(['string[]'], $this->methodReturnsArray());
    }

    public function testInvalidTypeMethodReturns(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodReturns();
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testMethodReturnsWithTooManyParameters(): void
    {
        $this->assertEquals('string', $this->methodReturnsWithTooManyParameters());
    }

    public function testMultipleMethodReturns(): void
    {
        $errorThrown = false;
        try {
            $this->multipleMethodReturns();
        } catch (Error) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testFunctionReturns(): void
    {
        $this->assertEquals('string', functionReturns());
    }

    #[Returns('string')]
    private function methodReturns(): string
    {
        return $this->getReturns(__FUNCTION__);
    }

    #[Returns('string[]')]
    private function methodReturnsArray(): array
    {
        return [$this->getReturns(__FUNCTION__)];
    }

    #[Returns(0)]
    private function invalidTypeMethodReturns(): string
    {
        return $this->getReturns(__FUNCTION__);
    }

    #[Returns('string', 'string')]
    private function methodReturnsWithTooManyParameters(): string
    {
        return $this->getReturns(__FUNCTION__);
    }

    #[Returns('string')]
    #[Returns('string')]
    private function multipleMethodReturns(): string
    {
        return $this->getReturns(__FUNCTION__);
    }

    private function getReturns(string $methodName): string
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getReturnsFromReflection($reflection);
    }

    public static function getReturnsFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): string {
        $attributes = $reflection->getAttributes();
        $returns = '';
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Returns::class) {
                $attribute->newInstance();
                $returns = $attribute->getArguments()[0];
            }
        }

        return $returns;
    }
}

#[Returns('string')]
function functionReturns(): string
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return ReturnsTest::getReturnsFromReflection($reflection);
}
