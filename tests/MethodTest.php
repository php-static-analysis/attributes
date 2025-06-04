<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Method;
use PHPUnit\Framework\TestCase;

#[Method('string getString()')]
#[Method(
    'void setString(string $text)',
    'static string staticGetter()',
)]
class MethodTest extends TestCase
{
    public function testClassMethods(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            'string getString()',
            'void setString(string $text)',
            'static string staticGetter()',
        ], self::getMethodsFromReflection($reflection));
    }

    public static function getMethodsFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $methods = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Method::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof Method);
                $methods = array_merge($methods, $instance->methods);
            }
        }

        return $methods;
    }
}
