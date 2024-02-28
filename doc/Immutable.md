# `Immutable` Attribute

This attribute is the equivalent of the `@immutable` annotation for classes, traits and interfaces.

## Arguments

The attribute accepts no arguments.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Immutable;

#[Immutable] // All properties are readonly
class ImmutableExample
{
    ...
}
```