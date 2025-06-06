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
        $instances = AttributeHelper::getInstances($reflection, TemplateExtends::class);
        $extends = '';
        foreach ($instances as $instance) {
            $extends = $instance->class;
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
