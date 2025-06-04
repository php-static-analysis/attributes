<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\TemplateCovariant;
use PhpStaticAnalysis\Attributes\TemplateUse;
use PHPUnit\Framework\TestCase;

#[TemplateCovariant('TClass', Exception::class)]
class TemplateCovariantTest extends TestCase
{
    public function testClassTemplateCovariant(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals(['TClass of Exception'], self::getTemplateCovariantsFromReflection($reflection));
    }

    public function testTraitTemplateCovariant(): void
    {
        $reflection = new ReflectionClass(TemplateCovariantTestTrait::class);
        $this->assertEquals(['TTrait'], self::getTemplateCovariantsFromReflection($reflection));
    }

    public function testInterfaceTemplateCovariant(): void
    {
        $reflection = new ReflectionClass(TemplateCovariantTestInterface::class);
        $this->assertEquals(['TInterface'], self::getTemplateCovariantsFromReflection($reflection));
    }

    public static function getTemplateCovariantsFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $templates = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === TemplateCovariant::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof TemplateCovariant);
                $templateValue = $instance->name;
                if ($instance->of !== null) {
                    $templateValue .= ' of ' . $instance->of;
                }
                $templates[] = $templateValue;
            }
        }

        return $templates;
    }
}

#[TemplateCovariant('TTrait')]
trait TemplateCovariantTestTrait
{
}

#[TemplateCovariant('TInterface')]
interface TemplateCovariantTestInterface
{
}

#[TemplateUse('TemplateCovariantTestTrait<string>')]
class CovariantClass
{
    use TemplateCovariantTestTrait;
}
