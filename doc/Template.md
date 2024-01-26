# `Template` Attribute

This attribute is the equivalent of the `@template` annotation. It can be used on class methods or on regular functions. It can also be applied to a class, trait or interface.

## Arguments

The attribute accepts one string that defines the name of the type variable and an optional string that defines its type. The attribute itself does not have a knowledge of which type variables are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the type variables accepted by static analysis tools for the `@template` annotation.

If the function, method or class has more than one type variable, you can add a list of `Template` attributes.

## Example usage

```php
<?php

use Exception;
use PhpStaticAnalysis\Attributes\Template;

#[Template('T')]
class TemplateExample
{
    // Single type variable
    #[Template('T')]
    public function methodWithTemplate(array $param)
    {
    }

    // Type variable with a type
    #[Template('T', Exception::class)]
    public function methodWithTemplate(array $param)
    {
    }

    // Multiple type varibles listed in multiple attributes
    #[Template('T1')]
    #[Template('T2')]
    public function multipleMethodTemplates(array $param1, array $param2)
    {
    }    
}
```
