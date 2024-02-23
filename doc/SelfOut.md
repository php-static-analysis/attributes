# `SelfOut` Attribute

This attribute is the equivalent of the `@self-out` or `@this-out` annotations. It can be used on class methods to specify the type of the current object after calling a method on it.

## Arguments

The attribute accepts a string which describes the type of the object after returning from the method. The attribute itself does not have a knowledge of which types are valid and which are not and this will depend on the implementation for each particular tool.

We expect that the attribute will be able to accept both basic types like `string` or `array` and more advanced types like `array<string>` or `Collection<int>`. We aim to accept all the types accepted by static analysis tools for the `@self-out` annotation.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Param;
use PhpStaticAnalysis\Attributes\SelfOut;
use PhpStaticAnalysis\Attributes\Template;

#[Template('TValue')]
class SelfOutExample
{
    #[Template('TItemValue')]
    #[Param(item: 'TItemValue')]
    #[SelfOut('self<TValue|TItemValue>')]
	public function add($item): void
	{
	}	
}

```
