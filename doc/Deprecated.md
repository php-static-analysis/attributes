# `Deprecated` Attribute

This attribute is the equivalent of the `@deprecated` annotation for classes, traits, interfaces, class properties, class methods, class constants and functions.

## Arguments

The attribute accepts no arguments.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Deprecated;

#[Deprecated] // Use NotDeprecatedClass instead
class DeprecatedExample
{
    #[Deprecated]
    public function getName(): string;
    
    ...
}
```