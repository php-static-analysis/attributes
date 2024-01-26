<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\Type;
use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
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

    private function getType(string $propertyName): string
    {
        $reflection = new ReflectionProperty($this, $propertyName);
        $attributes = $reflection->getAttributes();
        $type = '';
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === Type::class) {
                $attribute->newInstance();
                $type = $attribute->getArguments()[0];
            }
        }

        return $type;
    }
}
