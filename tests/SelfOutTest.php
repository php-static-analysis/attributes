<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\SelfOut;
use PhpStaticAnalysis\Attributes\Template;
use PHPUnit\Framework\TestCase;

#[Template('T')]
class SelfOutTest extends TestCase
{
    public function testMethodSelfOut(): void
    {
        $this->assertEquals('self<T>', $this->methodSelfOut());
    }

    public function testMethodSelfOutArray(): void
    {
        $this->assertEquals(['self<T>'], $this->methodSelfOutArray());
    }

    public function testInvalidTypeMethodSelfOut(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodSelfOut();
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testMethodSelfOutWithTooManyParameters(): void
    {
        $this->assertEquals('self<T>', $this->methodSelfOutWithTooManyParameters());
    }

    public function testMultipleMethodSelfOut(): void
    {
        $errorThrown = false;
        try {
            $this->multipleMethodSelfOut();
        } catch (Error) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    #[SelfOut('self<T>')]
    private function methodSelfOut(): string
    {
        return $this->getSelfOut(__FUNCTION__);
    }

    #[SelfOut('self<T>')]
    private function methodSelfOutArray(): array
    {
        return [$this->getSelfOut(__FUNCTION__)];
    }

    #[SelfOut(0)]
    private function invalidTypeMethodSelfOut(): string
    {
        return $this->getSelfOut(__FUNCTION__);
    }

    #[SelfOut('self<T>', 'string')]
    private function methodSelfOutWithTooManyParameters(): string
    {
        return $this->getSelfOut(__FUNCTION__);
    }

    #[SelfOut('self<T>')]
    #[SelfOut('self<T>')]
    private function multipleMethodSelfOut(): string
    {
        return $this->getSelfOut(__FUNCTION__);
    }

    private function getSelfOut(string $methodName): string
    {
        $reflection = new ReflectionMethod($this, $methodName);
        $attributes = $reflection->getAttributes();
        $selfOut = '';
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === SelfOut::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof SelfOut);
                $selfOut = $instance->type;
            }
        }

        return $selfOut;
    }
}
