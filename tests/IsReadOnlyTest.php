<?php

declare(strict_types=1);

use PhpStaticAnalysis\Attributes\IsReadOnly;
use PHPUnit\Framework\TestCase;

class IsReadOnlyTest extends TestCase
{
    #[IsReadOnly]
    public string $property;

    #[IsReadOnly(true)]
    public string $propertyWithValue;

    #[IsReadOnly]
    #[IsReadOnly]
    public string $propertyWithMultipleReadOnly;

    public function __construct()
    {
        parent::__construct();
        $this->property = 'Mike';
        $this->propertyWithValue = 'John';
        $this->propertyWithMultipleReadOnly = 'Mac';
    }

    public function testReadOnlyProperty(): void
    {
        $this->assertTrue($this->readOnlyProperty());
    }

    public function testReadOnlyPropertyWithValue(): void
    {
        $this->assertTrue($this->readOnlyPropertyWithValue());
    }

    public function testMultipleReadOnly(): void
    {
        $errorThrown = false;
        try {
            $this->multipleReadOnly();
        } catch (Error) {
            $errorThrown = true;
        }
        $this->assertTrue($errorThrown);
    }

    private function readOnlyProperty(): bool
    {
        return $this->getReadOnly('property');
    }

    private function readOnlyPropertyWithValue(): bool
    {
        return $this->getReadOnly('propertyWithValue');
    }

    private function multipleReadOnly(): bool
    {
        return $this->getReadOnly('propertyWithMultipleReadOnly');
    }

    private function getReadOnly(string $propertyName): bool
    {
        $reflection = new ReflectionProperty($this, $propertyName);
        $attributes = $reflection->getAttributes();
        $isReadOnly = false;
        foreach ($attributes as $attribute) {
            if ($attribute->getName() === IsReadOnly::class) {
                $attribute->newInstance();
                $isReadOnly = true;
            }
        }

        return $isReadOnly;
    }
}
