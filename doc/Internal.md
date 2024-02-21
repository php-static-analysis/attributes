# `Internal` Attribute

This attribute is the equivalent of the `@internal` annotation for classes, traits, interfaces, class properties, class methods, class constants and functions.

## Arguments

The attribute accepts one optional string argument that specifies the namespace to check. If left empty we assume it refers to the current top level namespace.

## Example usage

```php
<?php

namespace PhpStaticAnalysis\Attributes;

use PhpStaticAnalysis\Attributes\Internal;

#[Internal] // Cannot be used outside the current namespace
class InternalExample
{
    #[Internal('PhpStaticAnalysis\Attributes')]
    public function getName(): string;
    
    ...
}
```