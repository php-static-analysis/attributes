<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\ParamOut;
use PHPUnit\Framework\TestCase;

class ParamOutTest extends TestCase
{
    public function testMethodParamOut(): void
    {
        $text = 'Test';
        $this->assertEquals(['param' => 'string'], $this->methodParamOut($text));
    }

    public function testUnnamedMethodParamOut(): void
    {
        $text = 'Test';
        $this->assertEquals(['string $param'], $this->unnamedMethodParamOut($text));
    }

    public function testInvalidTypeMethodParamOut(): void
    {
        $errorThrown = false;
        $text = 'Test';
        try {
            $this->invalidTypeMethodParamOut($text);
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testSeveralMethodParamOuts(): void
    {
        $text = 'Test';
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->severalMethodParamOuts($text, $text));
    }

    public function testMultipleMethodParamOuts(): void
    {
        $text = 'Test';
        $this->assertEquals([
            'param1' => 'string',
            'param2' => 'string'
        ], $this->multipleMethodParamOuts($text, $text));
    }

    public function testFunctionParamOut(): void
    {
        $text = 'Test';
        $this->assertEquals(['param' => 'string'], functionParamOut($text));
    }

    public function testParamOutOnParam(): void
    {
        $text = 'Test';
        $this->assertEquals(['param' => 'string'], $this->paramOutOnParam($text));
    }

    #[ParamOut(param: 'string')]
    private function methodParamOut(string &$param): array
    {
        return $this->getParamOuts(__FUNCTION__);
    }

    #[ParamOut('string $param')]
    private function unnamedMethodParamOut(string &$param): array
    {
        return $this->getParamOuts(__FUNCTION__);
    }

    #[ParamOut(0)]
    private function invalidTypeMethodParamOut(string &$param): array
    {
        return $this->getParamOuts(__FUNCTION__);
    }

    #[ParamOut(
        param1: 'string',
        param2: 'string',
    )]
    private function severalMethodParamOuts(string &$param1, string &$param2): array
    {
        return $this->getParamOuts(__FUNCTION__);
    }

    #[ParamOut(param1: 'string')]
    #[ParamOut(param2: 'string')]
    private function multipleMethodParamOuts(string &$param1, string &$param2): array
    {
        return $this->getParamOuts(__FUNCTION__);
    }

    private function paramOutOnParam(
        #[ParamOut('string')]
        string &$param
    ): array {
        return $this->getParamOuts(__FUNCTION__);
    }

    private function getParamOuts(string $functionName): array
    {
        $reflection = new ReflectionMethod($this, $functionName);
        return self::getParamOutsFromReflection($reflection);
    }

    public static function getParamOutsFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): array {
        $instances = AttributeHelper::getFunctionInstances($reflection, ParamOut::class);
        $paramOuts = [];

        foreach ($instances['function'] as $instance) {
            $paramOuts = array_merge($paramOuts, $instance->params);
        }

        foreach ($instances['parameters'] as $name => $attrs) {
            foreach ($attrs as $instance) {
                $argument = $instance->params[array_key_first($instance->params)];
                $paramOuts[$name] = $argument;
            }
        }

        return $paramOuts;
    }
}

#[ParamOut(param: 'string')]
function functionParamOut(string &$param): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return ParamOutTest::getParamOutsFromReflection($reflection);
}
