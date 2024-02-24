<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\RequireExtends;
use PHPUnit\Framework\TestCase;

class RequireExtendsTest extends TestCase
{
    public function testClassRequireExtends(): void
    {
        $reflection = new ReflectionClass(RequireMyTrait::class);
        $this->assertEquals('RequireParentClass', self::getRequireExtendssFromReflection($reflection));
    }

    public static function getRequireExtendssFromReflection(
        ReflectionClass $reflection
    ): string {
        $attributes = $reflection->getAttributes();
        $extends = '';
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === RequireExtends::class) {
                $attribute->newInstance();
                $extends = $attribute->getArguments()[0];
            }
        }

        return $extends;
    }
}

class RequireParentClass
{
}

#[RequireExtends('RequireParentClass')]
trait RequireMyTrait
{
}

class RequireChildClass extends RequireParentClass
{
    use RequireMyTrait;
}
