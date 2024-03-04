# `Type` Attribute

This attribute is the equivalent of the `@var` annotation *when used for class properties or class constants* and is used to specify the type of this property or constant.

We could not use `Var` for the name of this attribute because `var` is a reserved word in PHP. By using `Type` we emphasize that this attribute is used to declare the type of a class property or constant.

This attribute can also be used instead of using the `Returns` attribute to specify the type of the return value of a function or method, replacing the `@return` annotation.

This attribute can also be used instead of using the `DefineType` attribute to specify an alias for a type, replacing the `@type` annotation.

## Arguments

The attribute accepts a string which describes the type of the class property, constant or return value. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@var` annotation.

If used to replace the `@type` tag, the value should be a string that includes both the name of the alias and the type being aliased.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Type;

#[Type('FloatArray float[]')]
class TypeExample
{
    #[Type('string')] // the type of this constant
    public const ATTRIBUTE_NAME = 'Type';

    #[Type('Array<int>')]
    private array $nums;

    #[Type('Array<int>')]
    private function returnsArray()
    {
        return [1];
    }    
    ...
}
```

## Caveat

This attribute can only be used to specify a type for class properties or class constants. It cannot replace the `@var` annotation when applied to define the type of a variable within arbitrary PHP code like in this example:

```php
    /** @var Array<string> $result */
    $result = $this->getResult();
```

This is because PHP attributes cannot be applied to arbitraty code, they can only be applied to specific targets like classes, functions, methods or properties. So the `@var` annotation might still be needed. However, if your code has good type coverage, ideally you should never need to use this kind of annotation.