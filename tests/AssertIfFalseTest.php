<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\AssertIfFalse;
use PHPUnit\Framework\TestCase;

class AssertIfFalseTest extends TestCase
{
    public function testMethodAssert(): void
    {
        $this->assertEquals(['param' => 'string'], $this->methodAssert('Test'));
    }

    public function testUnnamedMethodAssert(): void
    {
        $this->assertEquals(['string $param'], $this->unnamedMethodAssert('Test'));
    }

    public function testExpressionMethodAssert(): void
    {
        $this->assertEquals(['string $this->getName()'], $this->expressionMethodAssert('Test'));
    }

    public function testInvalidTypeMethodAssert(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodAssert('Test');
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testSeveralMethodAsserts(): void
    {
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->severalMethodAsserts('Test', 'Test'));
    }

    public function testMultipleMethodAsserts(): void
    {
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->multipleMethodAsserts('Test', 'Test'));
    }

    public function testFunctionAssert(): void
    {
        $this->assertEquals(['param' => 'string'], functionAssertIfFalse('Test'));
    }

    public function testAssertOnParam(): void
    {
        $this->assertEquals(['param' => 'string'], $this->assertOnParam('Test'));
    }

    #[AssertIfFalse(param: 'string')]
    private function methodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfFalse('string $param')]
    private function unnamedMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfFalse('string $this->getName()')]
    private function expressionMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfFalse(0)]
    private function invalidTypeMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfFalse(
        param1: 'string',
        param2: 'string',
    )]
    private function severalMethodAsserts(string $param1, string $param2): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfFalse(param1: 'string')]
    #[AssertIfFalse(param2: 'string')]
    private function multipleMethodAsserts(string $param1, string $param2): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    private function assertOnParam(
        #[AssertIfFalse('string')]
        string $param
    ): array {
        return $this->getAsserts(__FUNCTION__);
    }

    private function getAsserts(string $functionName): array
    {
        $reflection = new ReflectionMethod($this, $functionName);
        return self::getAssertsFromReflection($reflection);
    }

    public static function getAssertsFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $asserts = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === AssertIfFalse::class) {
                $attribute->newInstance();
                $asserts = array_merge($asserts, $attribute->getArguments());
            }
        }

        $parameters = $reflection->getParameters();
        foreach ($parameters as $parameter) {
            $attributes = $parameter->getAttributes();
            foreach ($attributes as $attribute) {
                if ($attribute->getName() === AssertIfFalse::class) {
                    $attribute->newInstance();
                    $arguments = $attribute->getArguments();
                    $argument = $arguments[array_key_first($arguments)];
                    $asserts[$parameter->name] = $argument;
                    ;
                }
            }
        }

        return $asserts;
    }
}

#[AssertIfFalse(param: 'string')]
function functionAssertIfFalse(string $param): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return AssertIfFalseTest::getAssertsFromReflection($reflection);
}
