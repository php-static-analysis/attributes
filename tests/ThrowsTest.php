<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Throws;
use PHPUnit\Framework\TestCase;

class ThrowsTest extends TestCase
{
    public function testMethodThrows(): void
    {
        $this->assertEquals(['Exception'], $this->methodThrows());
    }

    public function testInvalidTypeMethodThrows(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodThrows();
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testSeveralMethodThrows(): void
    {
        $this->assertEquals([
            'Exception',
            'Exception'
        ], $this->severalMethodThrowss());
    }

    public function testMultipleMethodThrows(): void
    {
        $this->assertEquals([
            'Exception',
            'Exception'
        ], $this->multipleMethodThrowss());
    }

    public function testFunctionThrows(): void
    {
        $this->assertEquals(['Exception'], functionThrows());
    }

    #[Throws(Exception::class)]
    private function methodThrows(): array
    {
        return $this->getThrows(__FUNCTION__);
    }

    #[Throws(0)]
    private function invalidTypeMethodThrows(): array
    {
        return $this->getThrows(__FUNCTION__);
    }

    #[Throws(
        Exception::class,
        Exception::class,
    )]
    private function severalMethodThrowss(): array
    {
        return $this->getThrows(__FUNCTION__);
    }

    #[Throws(Exception::class)]
    #[Throws(Exception::class)]
    private function multipleMethodThrowss(): array
    {
        return $this->getThrows(__FUNCTION__);
    }

    private function getThrows(string $functionName): array
    {
        $reflection = new ReflectionMethod($this, $functionName);
        return self::getThrowsFromReflection($reflection);
    }

    public static function getThrowsFromReflection(
        ReflectionMethod | ReflectionFunction $reflection
    ): array {
        $instances = AttributeHelper::getInstances($reflection, Throws::class);
        $throwss = [];
        foreach ($instances as $instance) {
            $throwss = array_merge($throwss, $instance->exceptions);
        }

        return $throwss;
    }
}

#[Throws(Exception::class)]
function functionThrows(): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return ThrowsTest::getThrowsFromReflection($reflection);
}
