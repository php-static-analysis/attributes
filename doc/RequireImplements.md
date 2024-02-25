# `RequireImplements` Attribute

This attribute is the equivalent of the `@require-implements` annotation. It can be applied to a trait to indicate that the class using it should implement one or more interfaces.

## Arguments

The attribute accepts one or more strings that define the interfaces that need to be implemented. The attribute itself does not have a knowledge of which interfaces are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the interface names accepted by static analysis tools for the `@require-implements` annotation.

The arguments need to be unnamed arguments.

If the class has more than one interface that we want to require, the different interfaces can either be declared as a list of strings for a single `RequireInterface` attribute or as a list of `RequireInterface` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\RequireImplements;

interface RequireInterface 
{
}

#[RequireImplements(RequireInterface::class)] //needs to implement this interface
trait MyTrait
{
}

class MyClass implements RequireInterface {
    use MyTrait;
}
```
