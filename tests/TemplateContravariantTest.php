<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\TemplateContravariant;
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
                if (isset($templateData[1]) && $templateData[1] !== null) {
                    $templateValue .= ' of ' . $templateData[1];
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
