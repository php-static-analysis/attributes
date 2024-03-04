# `DefineType` Attribute

This attribute is the equivalent of the `@type` annotation and is used to define new aliases for types and they are scoped to the class where they are defined. 

We are not using the `Type` name for this attribute because that name is used for the attribute which is equivalent to the `@var` annotation. But if you prefer, you can use the `Type` attribute instead of this one to define these aliases, but we don't recommend it.

## Arguments

The attribute accepts one or more strings which describe the aliased type. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@type` annotation.

The arguments can be named arguments and the type is aliased with the name of the argument.

They can also be unnamed arguments with a string that contains both the name of the alias and the aliased type, but we recommend using named arguments.

If the class has more than one type alias that we want to specify, the aliases can either be declared as a list of strings for a single `DefineType` attribute or as a list of `DefineType` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\DefineType;

#[DefineType(UserAddress: 'array{street: string, city: string, zip: string}')] // this is an alias of the listed type
#[DefineType('UserName array{firstName: string, lastName: string}')]
#[DefineType(
    StringArray: 'string[]',
    IntArray: 'int[]',
)]
class DefineTypeExample
{
    ...
}
```
