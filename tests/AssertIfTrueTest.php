<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\AssertIfTrue;
use PHPUnit\Framework\TestCase;

class AssertIfTrueTest extends TestCase
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
        $this->assertEquals(['param' => 'string'], functionAssertIfTrue('Test'));
    }

    public function testAssertOnParam(): void
    {
        $this->assertEquals(['param' => 'string'], $this->assertOnParam('Test'));
    }

    #[AssertIfTrue(param: 'string')]
    private function methodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfTrue('string $param')]
    private function unnamedMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfTrue('string $this->getName()')]
    private function expressionMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfTrue(0)]
    private function invalidTypeMethodAssert(string $param): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfTrue(
        param1: 'string',
        param2: 'string',
    )]
    private function severalMethodAsserts(string $param1, string $param2): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    #[AssertIfTrue(param1: 'string')]
    #[AssertIfTrue(param2: 'string')]
    private function multipleMethodAsserts(string $param1, string $param2): array
    {
        return $this->getAsserts(__FUNCTION__);
    }

    private function assertOnParam(
        #[AssertIfTrue('string')]
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
        $instances = AttributeHelper::getFunctionInstances($reflection, AssertIfTrue::class);
        $asserts = [];

        foreach ($instances['function'] as $instance) {
            $asserts = array_merge($asserts, $instance->params);
        }

        foreach ($instances['parameters'] as $name => $attrs) {
            foreach ($attrs as $instance) {
                $argument = $instance->params[array_key_first($instance->params)];
                $asserts[$name] = $argument;
            }
        }

        return $asserts;
    }
}

#[AssertIfTrue(param: 'string')]
function functionAssertIfTrue(string $param): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return AssertIfTrueTest::getAssertsFromReflection($reflection);
}
