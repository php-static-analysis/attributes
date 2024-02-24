# `RequireExtends` Attribute

This attribute is the equivalent of the `@require-extends` annotation. It can be applied to a trait to specify that the class using it must extend a specific class.

## Arguments

The attribute accepts one string that defines the class that needs to be extended. The attribute itself does not have a knowledge of which classes are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the classes accepted by static analysis tools for the `@require-extends` annotation.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\RequireExtends;

abstract class Parent {
}

#[RequireExtends('ParentClass')]
trait myTrait {
}

class Child extends Parent {
  use myTrait;
}
```
