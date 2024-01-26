# `Param` Attribute

This attribute is the equivalent of the `@param` annotation. It can be used on class methods or on regular functions.

## Arguments

The attribute accepts one or more strings which describes the types of the parameters. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@param` annotation.

The arguments can be named arguments and the type is applied to the parameter with the same name in the function or the class.

You can also pass an unnamed argument with a string that contains both the type and the name of the parameter, but we recommend using named arguments.

If the function or method has more than one parameter, the types for the different parameters can either be declared as a list of strings for a single `Param` attribute or as a list of `Param` attributes (or even a combination of both, though we don't expect this to be actually used).

If any of the parameters is variadic, the `...` operator needs to be listed with the type, not the argument name.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Param;

class ParamExample
{
    // Single parameter
    #[Param(param: 'string[]')]
    public function methodParamWithName(array $param)
    {
    }

    // Single parameter with unnamed argument
    #[Param('string[] $param')]
    public function methodParamWithoutName(array $param)
    {
    }

    // Multiple params listed in a single attribute
    #[Param(
        param1: 'string[]',
        param2: 'string[]',
    )]
    public function severalMethodParamsWithName(array $param1, array $param2)
    {
    }

    // Multiple params listed in multiple attributes
    #[Param(param1: 'string[]')]
    #[Param(param2: 'string[]')]
    public function multipleMethodParamsWithName(array $param1, array $param2)
    {
    }
    
    // variadic parameter
    #[Param(params: 'string ...')]
    public function variadicMethodParam(...$params)
    {
    }    
}
```
