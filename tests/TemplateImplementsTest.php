<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateImplements;
use PHPUnit\Framework\TestCase;

#[Template(('T'))]
interface TestInterface
{
}

#[Template(('T'))]
interface TestInterface2
{
}

#[Template(('T'))]
interface TestInterface3
{
}

#[TemplateImplements('TestInterface<int>')]
#[TemplateImplements(
    'TestInterface2<int>',
    'TestInterface3<int>'
)]
class TemplateImplementsTest extends TestCase implements TestInterface, TestInterface2, TestInterface3
{
    public function testClassTemplateImplements(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            'TestInterface<int>',
            'TestInterface2<int>',
            'TestInterface3<int>',
        ], self::getTemplateImplementssFromReflection($reflection));
    }

    public static function getTemplateImplementssFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $implements = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === TemplateImplements::class) {
                $attribute->newInstance();
                $implements = array_merge($implements, $attribute->getArguments());
            }
        }

        return $implements;
    }
}
