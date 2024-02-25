# `Impure` Attribute

This attribute is the equivalent of the `@impure` annotation for class methods and functions.

## Arguments

The attribute accepts no arguments.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Impure;

class ImpureExample
{
    public static int $i = 0;
    
    #[Impure] // this function is impure
    public static function addCumulative(int $left) : int
    {
        self::$i += $left;
        return self::$i;
    }
    
  ...
}
```