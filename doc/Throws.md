# `Throws` Attribute

This attribute is the equivalent of the `@throws` annotation. It can be applied to a method or function to indicate the exceptions that are thrown by them.

## Arguments

The attribute accepts one or more strings that define the types of exceptions that are thrown. The attribute itself does not have a knowledge of which exceptions are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the exceptions accepted by static analysis tools for the `@throws` annotation.

The arguments need to be unnamed arguments and the value should match the type of the exception thrown by the class.

If the class throws more than one type of exceptions, the types of the different exceptions can either be declared as a list of strings for a single `Throws` attribute or as a list of `Throws` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use SpecialException;
use PhpStaticAnalysis\Attributes\Throws;

class MyClass use TemplateInterface {
    
    #[Throws(SpecialException::class)]
    public function throwsException(): void
    {
        throw new SpecialException();
    }
}
```
