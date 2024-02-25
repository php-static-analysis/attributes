# `TemplateImplements` Attribute

This attribute is the equivalent of the `@implements` or `@template-implements` annotations. It can be applied to a class.

## Arguments

The attribute accepts one or more strings that define the type of the templated interfaces that are implemented. The attribute itself does not have a knowledge of which interface types are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the interface types accepted by static analysis tools for the `@template-implements` annotation.

The arguments need to be unnamed arguments.

If the class has more than one interface that we want to specify, the types for the different interfaces can either be declared as a list of strings for a single `TemplateInterface` attribute or as a list of `TemplateInterface` attributes (or even a combination of both, though we don't expect this to be actually used).

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateImplements;

#[Template('T')]
interface TemplateInterface {}

#[TemplateImplements('TemplateInterface<int>')] // this is the type of the implemented interface
class MyClass implements TemplateInterface {}
```
