# `TemplateExtends` Attribute

This attribute is the equivalent of the `@extends` or `@template-extends` annotations. It can be applied to a class.

## Arguments

The attribute accepts one string that defines the type of the templated class that is extended. The attribute itself does not have a knowledge of which class types are valid and which are not and this will depend on the implementation for each particular tool.

We aim to accept all the class types accepted by static analysis tools for the `@template-extends` annotation.

## Example usage

```php
<?php

use PhpStaticAnalysis\Attributes\Template;
use PhpStaticAnalysis\Attributes\TemplateExtends;

#[Template('T')]
class ParentClass {}

#[TemplateExtends('ParentClass<int>')]
class ChildClass extends ParentClass {}
```
