# `ImportType` Attribute

This attribute is the equivalent of the `@import-type` annotation and is used to import aliases for types from another class. 

## Arguments

The attribute accepts one or more strings which list the class from which the aliased type neeeds to be imported. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

The arguments can be named arguments and the type is aliased with the name of the argument and the value is the name of the class from which it needs to be imported.

They can also be unnamed arguments with a string that contains both the name of the alias and the name of the class from which it needs to be imported, but we recommend using named arguments.

If the class has more than one type alias that we want to specify, the aliases can either be declared as a list of strings for a single `ImportType` attribute or as a list of `ImportType` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\ImportType;

#[ImportType(UserAddress: User::class)] // this type is imported from the user class
#[ImportType('UserName from User')]
#[ImportType(
    stringArray: 'StringClass',
    intArray: 'IntClass',
)]
class ImportTypeExample
{
    ...
}
```
