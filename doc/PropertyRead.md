# `PropertyRead` Attribute

This attribute is the equivalent of the `@property-read` annotation and is used to specify the type of properties accessed through magic `__get` methods. These properties can only be read and not written to. It can also be used to override wrong property types from a parent class. 

## Arguments

The attribute accepts one or more strings which describe the type of the properties. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@property-read` annotation.

The arguments can be named arguments and the type is applied to the properties with the same name in the class.

They can also be unnamed arguments with a string that contains both the type and the name of the property, but we recommend using named arguments.

If the class has more than one property that we want to specify, the types for the different properties can either be declared as a list of strings for a single `PropertyRead` attribute or as a list of `PropertyRead` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\PropertyRead;

#[PropertyRead(name: 'string')] // these properties cannot be written to
#[PropertyRead('int $age')]
#[PropertyRead(
    index1: 'string[]',
    index2: 'string[]',
)]
class PropertyReadExample
{
    ...
}
```
