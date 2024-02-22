<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateExtends;
use PHPUnit\Framework\TestCase;

class TemplateExtendsTest extends TestCase
{
    public function testClassTemplateExtends(): void
    {
        $reflection = new ReflectionClass(ChildClass::class);
        $this->assertEquals('ParentClass<int>', self::getTemplateExtendssFromReflection($reflection));
    }

    public static function getTemplateExtendssFromReflection(
        ReflectionClass $reflection
    ): string {
        $attributes = $reflection->getAttributes();
        $extends = '';
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === TemplateExtends::class) {
                $attribute->newInstance();
                $extends = $attribute->getArguments()[0];
            }
        }

        return $extends;
    }
}

#[Template('T')]
class ParentClass
{
}

#[TemplateExtends('ParentClass<int>')]
class ChildClass extends ParentClass
{
}
