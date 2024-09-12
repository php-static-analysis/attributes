# `AssertIfFalse` Attribute

This attribute is the equivalent of the `@assert-if-false` annotation. It can be used on class methods or on regular functions.

## Arguments

The attribute accepts one or more strings which describes the assertion that is performed on the parameter and that will the function return false. The attribute itself does not have a knowledge of which assertions are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept all the types accepted by static analysis tools for the `@assert-if-false` annotation.

The arguments can be named arguments and the assertion is applied to the parameter with the same name in the function or the class.

You can also pass an unnamed argument with a string that contains both the assertion and the name of the parameter, but we recommend using named arguments. This later form can also be used to pass more complex assertions on members of the class, for example.

If the function or method has more than one parameter, the assertions for the different parameters can either be declared as a list of strings for a single `AssertIfFalse` attribute or as a list of `AssertIfFalse` attributes (or even a combination of both, though we don't expect this to be actually used).

You can also directly apply the attribute to any of the method/function parameters. In that case, the name of the argument is optional and, if added, should match the name of the parameter to which it is applied.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\AssertIfFalse;

class AssertIfFalseExample
{
    // Single parameter
    #[AssertIfFalse(param: 'string')]
    public function methodThatAssertsParamIsNotString($param): bool
    {
    }

    // Single parameter with unnamed argument
    #[AssertIfFalse('string $param')]
    public function methodThatAssertsParamIsNotString($param): bool
    {
    }

    // Assert performed on something which is not a param
    #[AssertIfFalse('null $this->getName()')]
    public function methodThatAssertsThatNameIsNotNull($param): bool
    {
    }

    // Multiple params listed in a single attribute
    #[AssertIfFalse(
        param1: 'string',
        param2: 'Foo',
    )]
    public function methodThatAssertsBothParameters($param1, $param2): bool
    {
    }

    // Multiple params listed in multiple attributes
    #[AssertIfFalse(param1: 'string')]
    #[AssertIfFalse(param2: 'Foo')]
    public function methodThatAssertsBothParameters($param1, $param2): bool
    {
    }
    
    // Attribute applied at parameter level
    public function assertOnParam(
        #[AssertIfFalse('string')]
        array $param
    ): bool {
    }
}
```
