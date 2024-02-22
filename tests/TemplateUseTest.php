<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateUse;
use PHPUnit\Framework\TestCase;

#[Template(('T'))]
trait TestTrait
{
}

#[Template(('T'))]
trait TestTrait2
{
}

#[Template(('T'))]
trait TestTrait3
{
}

#[TemplateUse('TestTrait<int>')]
#[TemplateUse(
    'TestTrait2<int>',
    'TestTrait3<int>'
)]
class TemplateUseTest extends TestCase
{
    use TestTrait, TestTrait2, TestTrait3;

    public function testClassTemplateUse(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals([
            'TestTrait<int>',
            'TestTrait2<int>',
            'TestTrait3<int>',
        ], self::getTemplateUsesFromReflection($reflection));
    }

    public static function getTemplateUsesFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $uses = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === TemplateUse::class) {
                $attribute->newInstance();
                $uses = array_merge($uses, $attribute->getArguments());
            }
        }

        return $uses;
    }
}
