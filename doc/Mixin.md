# `Mixin` Attribute

This attribute is the equivalent of the `@mixin` annotation and is used to specify that the class will proxy the methods and properties of the referenced class. 

## Arguments

The attribute accepts one or more strings which describe the name of the referenced classes. The attribute itself does not have a knowledge of which signatures are valid and which are not and this will depend on the implementation for each particular tool.

The arguments need to be unnamed arguments.

If the class has more than one mixin that we want to specify, the names of the referenced classes can either be declared as a list of strings for a single `Mixin` attribute or as a list of `Mixin` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Mixin;

class A
{
    public function doA(): void
    {
    }
}

 #[Mixin('A')]
class B
{
    public function doB(): void
    {
    }

    public function __call($name, $arguments)
    {
        (new A())->$name(...$arguments);
    }
}

$b = new B();
$b->doB();
$b->doA(); // works
```
