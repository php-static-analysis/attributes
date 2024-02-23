# `ParamOut` Attribute

This attribute is the equivalent of the `@param-out` annotation and is used to specify the output type of a parameter passed by reference. It can be used on class methods or on regular functions.

## Arguments

The attribute accepts one or more strings which describes the output types of the parameters. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@param-out` annotation.

The arguments can be named arguments and the output type is applied to the parameter with the same name in the function or the class.

You can also pass an unnamed argument with a string that contains both the type and the name of the parameter, but we recommend using named arguments.

If the function or method has more than one parameter passed by reference, the output types for the different parameters can either be declared as a list of strings for a single `ParamOut` attribute or as a list of `ParamOut` attributes (or even a combination of both, though we don't expect this to be actually used).

You can also directly apply the attribute to any of the method/function parameters. In that case, the name of the argument is optional and, if added, should match the name of the parameter to which it is applied.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\ParamOut;

class ParamExample
{
    // Single parameter
    #[ParamOut(param: 'string')]
    public function methodParamWithName(mixed &$param)
    {
    }

    // Single parameter with unnamed argument
    #[ParamOut('string $param')]
    public function methodParamWithoutName(mixed &$param)
    {
    }

    // Multiple params listed in a single attribute
    #[ParamOut(
        param1: 'string',
        param2: 'string',
    )]
    public function severalMethodParamsWithName(mixed &$param1, mixed &$param2)
    {
    }

    // Multiple params listed in multiple attributes
    #[ParamOut(param1: 'string')]
    #[ParamOut(param2: 'string')]
    public function multipleMethodParamsWithName(mixed &$param1, mixed &$param2)
    {
    }
    
    // Attribute applied at parameter level
    public function paramOnParam(
        #[ParamOut('string')]
        mixed &$param
    ) {
    }
}
```
