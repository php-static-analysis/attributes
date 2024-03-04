# `TemplateContravariant` Attribute

This attribute is the equivalent of the `@template-contravariant` annotation. It can be applied to a class, trait or interface.

## Arguments

The attribute accepts one string that defines the name of the type variable and an optional string that defines its type. The attribute itself does not have a knowledge of which type variables are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the type variables accepted by static analysis tools for the `@template-contravariant` annotation.

If the class has more than one type variable, you can add a list of `TemplateContravariant` attributes.

## Example usage

```php
<?php

use Exception;
use PhpStaticAnalysis\Attributes\TemplateContravariant;

#[TemplateContravariant('T')]
#[TemplateContravariant('T', of:Exception::class)]
class TemplateContravariantExample
{
}
```
