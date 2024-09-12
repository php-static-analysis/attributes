# `Assert` Attribute

This attribute is the equivalent of the `@assert` annotation. It can be used on class methods or on regular functions.

## Arguments

The attribute accepts one or more strings which describes the assertion that is performed on the parameter. The attribute itself does not have a knowledge of which assertions are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept all the types accepted by static analysis tools for the `@assert` annotation.

The arguments can be named arguments and the assertion is applied to the parameter with the same name in the function or the class.

You can also pass an unnamed argument with a string that contains both the assertion and the name of the parameter, but we recommend using named arguments.

If the function or method has more than one parameter, the assertions for the different parameters can either be declared as a list of strings for a single `Assert` attribute or as a list of `Assert` attributes (or even a combination of both, though we don't expect this to be actually used).

You can also directly apply the attribute to any of the method/function parameters. In that case, the name of the argument is optional and, if added, should match the name of the parameter to which it is applied.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Assert;

class AssertExample
{
    // Single parameter
    #[Assert(param: 'string')]
    public function methodThatAssertsParamIsString($param)
    {
    }

    // Single parameter with unnamed argument
    #[Assert('string $param')]
    public function methodThatAssertsParamIsString($param)
    {
    }

    // Multiple params listed in a single attribute
    #[Assert(
        param1: 'string',
        param2: 'Foo',
    )]
    public function methodThatAssertsBothParameters($param1, $param2)
    {
    }

    // Multiple params listed in multiple attributes
    #[Assert(param1: 'string')]
    #[Assert(param2: 'Foo')]
    public function methodThatAssertsBothParameters($param1, $param2)
    {
    }
    
    // Attribute applied at parameter level
    public function assertOnParam(
        #[Assert('string')]
        array $param
    ) {
    }
}
```
