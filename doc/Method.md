# `Method` Attribute

This attribute is the equivalent of the `@method` annotation and is used to specify the methods defined through magic `__call` methods, including methods called in a parent class. 

## Arguments

The attribute accepts one or more strings which describe the signature of these methods. The attribute itself does not have a knowledge of which signatures are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept all the signatures accepted by static analysis tools for the `@method` annotation.

The arguments need to be unnamed arguments.

If the class has more than one method that we want to specify, the types for the different properties can either be declared as a list of strings for a single `Method` attribute or as a list of `Method` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Method;

#[Method('string getString()')]
#[Method(
    'void setString(string $text)',
    'static string staticGetter()',
)]
class MethodExample
{
    ...
}
```
