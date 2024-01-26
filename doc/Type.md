# `Type` Attribute

This attribute is the equivalent of the `@var` annotation *when used for class properties or class constants*.

We could not use `Var` for the name of this attribute because `var` is a reserved word in PHP. By using `Type` we emphasize that this attribute is used to declare the type of a class property or constant.

## Arguments

The attribute accepts a string which describes the type of the class property or constant. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@var` annotation.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Type;

class TypeExample
{
    #[Type('string')]
    public const ATTRIBUTE_NAME = 'Type';

    #[Type('Array<int>')]
    private array $nums;
    
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