<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Param;
use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateUse;
use PHPUnit\Framework\TestCase;

#[Template('TClass')]
class TemplateTest extends TestCase
{
    public function testClassTemplate(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals(['TClass'], self::getTemplatesFromReflection($reflection));
    }

    public function testTraitTemplate(): void
    {
        $reflection = new ReflectionClass(TemplateTestTrait::class);
        $this->assertEquals(['TTrait'], self::getTemplatesFromReflection($reflection));
    }

    public function testInterfaceTemplate(): void
    {
        $reflection = new ReflectionClass(TemplateTestInterface::class);
        $this->assertEquals(['TInterface'], self::getTemplatesFromReflection($reflection));
    }

    public function testMethodTemplate(): void
    {
        $this->assertEquals(['TMethod'], $this->methodTemplate('Test'));
    }

    public function testMethodTemplateWithType(): void
    {
        $this->assertEquals(['TMethod of Exception'], $this->methodTemplateWithType('Test'));
    }

    public function testInvalidTypeMethodTemplate(): void
    {
        $errorThrown = false;
        try {
            $this->invalidTypeMethodTemplate();
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testMethodWithMultipleTemplates(): void
    {
        $this->assertEquals(['T1', 'T2'], $this->methodWithMultipleTemplates('Test', 'Test'));
    }

    public function testFunctionTemplate(): void
    {
        $this->assertEquals(['TFunction'], functionTemplate('Test'));
    }

    #[Template('TMethod')]
    #[Param(param: 'TMethod')]
    private function methodTemplate($param): array
    {
        return $this->getTemplates(__FUNCTION__);
    }

    #[Template('TMethod', Exception::class)]
    #[Param(param: 'TMethod')]
    private function methodTemplateWithType($param): array
    {
        return $this->getTemplates(__FUNCTION__);
    }

    #[Template(0)]
    private function invalidTypeMethodTemplate(): array
    {
        return $this->getTemplates(__FUNCTION__);
    }

    #[Template('T1')]
    #[Template('T2')]
    #[Param(param1: 'T1')]
    #[Param(param2: 'T2')]
    private function methodWithMultipleTemplates($param1, $param2): array
    {
        return $this->getTemplates(__FUNCTION__);
    }

    private function getTemplates(string $methodName): array
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getTemplatesFromReflection($reflection);
    }

    public static function getTemplatesFromReflection(
        ReflectionMethod | ReflectionFunction | ReflectionClass $reflection
    ): array {
        $attributes = $reflection->getAttributes();
        $templates = [];
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Template::class) {
                $instance = $attribute->newInstance();
                assert($instance instanceof Template);
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

#[Template('TTrait')]
trait TemplateTestTrait
{
}

#[Template('TInterface')]
interface TemplateTestInterface
{
}

#[TemplateUse('TemplateTestTrait<string>')]
class TemplateClass
{
    use TemplateTestTrait;
}


#[Template('TFunction')]
#[Param(param: 'TFunction')]
function functionTemplate($param): array
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return TemplateTest::getTemplatesFromReflection($reflection);
}
