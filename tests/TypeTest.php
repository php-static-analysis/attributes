<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Type;
use PHPUnit\Framework\TestCase;

#[Type('FloatArray float[]')]
class TypeTest extends TestCase
{
    #[Type('string')]
    public const NAME = 'name';

    #[Type('string')]
    public string $property;

    #[Type('string[]')]
    public array $arrayProperty;

    #[Type(0)]
    public string $invalidTypeProperty;

    #[Type('string', 'string')]
    public string $propertyWithTooManyParameters;

    #[Type('string')]
    #[Type('string')]
    public string $propertyWithMultipleTypes;

    public function testClassTemplate(): void
    {
        $reflection = new ReflectionClass($this);
        $this->assertEquals('FloatArray float[]', self::getTypeFromReflection($reflection));
    }

    public function testClassConstantType(): void
    {
        $reflection = new ReflectionClassConstant($this, 'NAME');
        $this->assertEquals('string', self::getTypeFromReflection($reflection));
    }

    public function testPropertyType(): void
    {
        $this->assertEquals('string', $this->propertyType());
    }

    public function testArrayPropertyType(): void
    {
        $this->assertEquals('string[]', $this->arrayPropertyType());
    }

    public function testInvalidTypePropertyType(): void
    {
        $errorThrown = false;
        try {
            $this->invalidPropertyType();
        } catch (TypeError) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testPropertyTypeWithTooManyParameters(): void
    {
        $this->assertEquals('string', $this->propertyTypeWithTooManyParameters());
    }

    public function testMultiplePropertyTypes(): void
    {
        $errorThrown = false;
        try {
            $this->multiplePropertyTypes();
        } catch (Error) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    public function testMethodType(): void
    {
        $this->assertEquals('string', $this->methodType());
    }

    public function testFunctionType(): void
    {
        $this->assertEquals('string', functionType());
    }

    private function propertyType(): string
    {
        return $this->getType('property');
    }

    private function arrayPropertyType(): string
    {
        return $this->getType('arrayProperty');
    }

    private function invalidPropertyType(): string
    {
        return $this->getType('invalidTypeProperty');
    }

    private function propertyTypeWithTooManyParameters(): string
    {
        return $this->getType('propertyWithTooManyParameters');
    }

    private function multiplePropertyTypes(): string
    {
        return $this->getType('propertyWithMultipleTypes');
    }

    #[Type('string')]
    private function methodType(): string
    {
        return $this->getMethodType(__FUNCTION__);
    }

    private function getType(string $propertyName): string
    {
        $reflection = new ReflectionProperty($this, $propertyName);
        return self::getTypeFromReflection($reflection);
    }

    private function getMethodType(string $methodName): string
    {
        $reflection = new ReflectionMethod($this, $methodName);
        return self::getTypeFromReflection($reflection);
    }

    public static function getTypeFromReflection(
        ReflectionProperty | ReflectionClassConstant | ReflectionMethod | ReflectionFunction | ReflectionClass $reflection
    ): string {
        $instances = AttributeHelper::getInstances($reflection, Type::class);
        $type = '';
        foreach ($instances as $instance) {
            $type = $instance->type;
        }

        return $type;
    }
}

#[Type('string')]
function functionType(): string
{
    $reflection = new ReflectionFunction(__FUNCTION__);
    return TypeTest::getTypeFromReflection($reflection);
}
