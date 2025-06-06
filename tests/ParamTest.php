<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Param;
use PHPUnit\Framework\TestCase;

class ParamTest extends TestCase
{
    public function testMethodParam(): void
    {
        $this->assertEquals(['param' => 'string'], $this->methodParam('Test'));
    }

    public function testUnnamedMethodParam(): void
    {
        $this->assertEquals(['string $param'], $this->unnamedMethodParam('Test'));
    }

    public function testInvalidTypeMethodParam(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodParam('Test');
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testSeveralMethodParams(): void
    {
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->severalMethodParams('Test', 'Test'));
    }

    public function testMultipleMethodParams(): void
    {
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->multipleMethodParams('Test', 'Test'));
    }

    public function testFunctionParam(): void
    {
        $this->assertEquals(['param' => 'string'], functionParam('Test'));
    }

    public function testVariadicMethodParam(): void
    {
        $this->assertEquals(['params' => 'string ...'], $this->variadicMethodParam('Test'));
    }

    public function testParamOnParam(): void
    {
        $this->assertEquals(['param' => 'string'], $this->paramOnParam('Test'));
    }

    #[Param(param: 'string')]
    private function methodParam(string $param): array
    {
        return $this->getParams(__FUNCTION__);
    }

    #[Param('string $param')]
    private function unnamedMethodParam(string $param): array
    {
        return $this->getParams(__FUNCTION__);
    }

    #[Param(0)]
    private function invalidTypeMethodParam(string $param): array
    {
        return $this->getParams(__FUNCTION__);
    }

    #[Param(
        param1: 'string',
        param2: 'string',
    )]
    private function severalMethodParams(string $param1, string $param2): array
    {
        return $this->getParams(__FUNCTION__);
    }

    #[Param(param1: 'string')]
    #[Param(param2: 'string')]
    private function multipleMethodParams(string $param1, string $param2): array
    {
        return $this->getParams(__FUNCTION__);
    }

    #[Param(params: 'string ...')]
    private function variadicMethodParam(string ...$params): array
    {
        return $this->getParams(__FUNCTION__);
    }

    private function paramOnParam(
        #[Param('string')]
        string $param
    ): array {
        return $this->getParams(__FUNCTION__);
    }

    private function getParams(string $functionName): array
    {
        $reflection = new ReflectionMethod($this, $functionName);
        return self::getParamsFromReflection($reflection);
    }

    public static function getParamsFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): array {
        $instances = AttributeHelper::getFunctionInstances($reflection, Param::class);
        $params = [];

        foreach ($instances['function'] as $instance) {
            $params = array_merge($params, $instance->params);
        }

        foreach ($instances['parameters'] as $name => $attrs) {
            foreach ($attrs as $instance) {
                $argument = $instance->params[array_key_first($instance->params)];
                $params[$name] = $argument;
            }
        }

        return $params;
    }
}

#[Param(param: 'string')]
function functionParam(string $param): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return ParamTest::getParamsFromReflection($reflection);
}
