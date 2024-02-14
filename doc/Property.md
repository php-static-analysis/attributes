# `Property` Attribute

This attribute is the equivalent of the `@property` annotation and is used to specify the type of properties accessed through magic `__get/__set` methods. It can also be used to override wrong property types from a parent class. 

This attribute can also be used instead of the `Type` attribute to specify the type of a class property, replacing the `@var` annotation.

## Arguments

The attribute accepts one or more strings which describe the type of the properties. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@property` annotation.

The arguments can be named arguments and the type is applied to the properties with the same name in the class.

They can also be unnamed arguments with a string that contains both the type and the name of the property, but we recommend using named arguments.

If the class has more than one property that we want to specify, the types for the different properties can either be declared as a list of strings for a single `Property` attribute or as a list of `Property` attributes (or even a combination of both, though we don't expect this to be actually used).

If the attribute is used as a replacement for the `Type` attribute for a property, then you should use a single unnamed argument.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Property;

#[Property(name: 'string')]
#[Property('int $age')]
#[Property(
    index1: 'string[]',
    index2: 'string[]',
)]
class PropertyExample
{
    #[Property('Array<int>')]
    private array $nums;

    ...
}
```
