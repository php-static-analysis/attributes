<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Param;
use PhpStaticAnalysis\Attributes\TemplateCovariant;
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

#[TemplateCovariant('TTrait')]
trait TemplateCovariantTestTrait
{
}

#[TemplateCovariant('TInterface')]
interface TemplateCovariantTestInterface
{
}
