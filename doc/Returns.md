# `Returns` Attribute

This attribute is the equivalent of the `@return` annotation. It can be used on class methods or on regular functions.

We could not use `Return` for the name of this attribute because `return` is a reserved word in PHP.

Instead of using this attribute, you can also use the `Type` aatribute which provides equivalent functionality.

## Arguments

The attribute accepts a string which describes the type of the value returned by the function or method. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@return` annotation.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Returns;

class ReturnsExample
{
    #[Returns('Array<string>')]
    public function getNames(): array
    {
        return ['Fred', 'John'];
    }    
}
```
