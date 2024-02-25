# `Pure` Attribute

This attribute is the equivalent of the `@pure` annotation for class methods and functions.

## Arguments

The attribute accepts no arguments.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Pure;

class PureExample
{
    #[Pure]
    public static function add(int $left, int $right) : int 
    {
        return $left + $right;
    }
    
  ...
}
```