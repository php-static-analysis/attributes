# `IsReadOnly` Attribute

This attribute is the equivalent of the `@readonly` annotation for class properties.

We could not use `ReadOnly` for the name of this attribute because `readonly` is a reserved word in PHP.

## Arguments

The attribute accepts no arguments.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\IsReadOnly;

class IsReadOnlyExample
{
    #[IsReadOnly]
    public string $name;
    
    ...
}
```