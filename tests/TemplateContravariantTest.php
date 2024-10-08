<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\TemplateContravariant;
use PhpStaticAnalysis\Attributes\TemplateUse;
use PHPUnit\Framework\TestCase;

#[TemplateContravariant('TClass', Exception::class)]
class TemplateContravariantTest extends TestCase
{
    public function testClassTemplateContravariant(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals(['TClass of Exception'], self::getTemplateContravariantsFromReflection($reflection));
    }

    public function testTraitTemplateContravariant(): void
    {
        $reflection = new ReflectionClass(TemplateContravariantTestTrait::class);
        $this->assertEquals(['TTrait'], self::getTemplateContravariantsFromReflection($reflection));
    }

    public function testInterfaceTemplateContravariant(): void
    {
        $reflection = new ReflectionClass(TemplateContravariantTestInterface::class);
        $this->assertEquals(['TInterface'], self::getTemplateContravariantsFromReflection($reflection));
    }

    public static function getTemplateContravariantsFromReflection(
        ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $templates = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === TemplateContravariant::class) {
                $attribute->newInstance();
                $templateData = $attribute->getArguments();
                $templateValue = $templateData[0];
                assert(is_string($templateValue));
                if (isset($templateData[1])) {
                    $className = $templateData[1];
                    assert(is_string($className));
                    $templateValue .= ' of ' . $className;
                }
                $templates[] = $templateValue;
            }
        }

        return $templates;
    }
}

#[TemplateContravariant('TTrait')]
trait TemplateContravariantTestTrait
{
}

#[TemplateContravariant('TInterface')]
interface TemplateContravariantTestInterface
{
}

#[TemplateUse('TemplateContravariantTestTrait<string>')]
class ContravariantClass
{
    use TemplateContravariantTestTrait;
}
