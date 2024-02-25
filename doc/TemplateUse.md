# `TemplateUse` Attribute

This attribute is the equivalent of the `@use` or `@template-use` annotations. It can be applied to a class.

Please notice that the `@use` annotation is applied to the `use` statement for any trait used by the class. But PHP attributes cannot be applied to `use` statements so it needs to be added at the class level instead.

## Arguments

The attribute accepts one or more strings that define the types of the templated traits that are used. The attribute itself does not have a knowledge of which trait types are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the trait types accepted by static analysis tools for the `@template-use` annotation.

The arguments need to be unnamed arguments and the value should match the name of one of the traits used by the class.

If the class has more than one trait that we want to specify, the types for the different traits can either be declared as a list of strings for a single `TemplateUse` attribute or as a list of `TemplateUse` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateUse;

#[Template('T')]
trait TemplateTrait {}

#[TemplateUse('TemplateTrait<int>')] // this is the type of the used trait
class MyClass use TemplateInterface {
    use TemplateTrait;
}
```
