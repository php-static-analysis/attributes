# PHP Static Analysis Attributes

[![Continuous Integration](https://github.com/php-static-analysis/attributes/workflows/All%20Tests/badge.svg)](https://github.com/php-static-analysis/attributes/actions)
[![Latest Stable Version](https://poser.pugx.org/php-static-analysis/attributes/v/stable)](https://packagist.org/packages/php-static-analysis/attributes)
[![PHP Version Require](http://poser.pugx.org/php-static-analysis/attributes/require/php)](https://packagist.org/packages/php-static-analysis/attributes)
[![License](https://poser.pugx.org/php-static-analysis/attributes/license)](https://github.com/php-static-analysis/attributes/blob/main/LICENSE)
[![Total Downloads](https://poser.pugx.org/php-static-analysis/attributes/downloads)](https://packagist.org/packages/php-static-analysis/attributes/stats)

Since the release of PHP 8.0 more and more libraries, frameworks and tools have been updated to use attributes instead of annotations in PHPDocs.

However, static analysis tools like PHPStan or Psalm or IDEs like PHPStorm or VS Code have not made this transition to attributes and they still rely on annotations in PHPDocs for a lot of their functionality.

This library aims to provide a set of PHP attributes which could replace the most commonly used annotations accepted by these tools and will aim to provide related repositories with the extensions or plugins that would allow these attributes to be used in these tools.

In particular, these repositories are:

- [PHPStan extension](https://github.com/php-static-analysis/phpstan-extension)
- [Psalm plugin](https://github.com/php-static-analysis/psalm-plugin)
- [RectorPHP rules to migrate annotations to attributes](https://github.com/php-static-analysis/rector-rule)

## PHPStorm
A plugin that fully supports these attributes will need to be created. Until this is ready you can get partial support by installing PHPStan, our PHPStan extension and enabling PHPStan support in PHPStorm (as described [here](https://www.jetbrains.com/help/phpstorm/using-phpstan.html)). You will then be able to see errors and messages related to these attributes in your code.

Alternatively install Psalm, our Psalm extension and enable Psalm support in PHPStorm (as described [here](https://www.jetbrains.com/help/phpstorm/using-psalm.html))

## VS Code Support
An extension that fully supports these attributes will need to be created. Until this is ready you can get partial support by installing PHPStan, our PHPStan extension and a VS Code extension that supports PHPStan (for example [this one](https://github.com/SanderRonde/phpstan-vscode)). When you enable the extension you will be able to see errors and messages related to these attributes in your code.

Alternatively install Psalm, our Psalm extension and a VS Code extension that supports Psam (for example [this one](https://github.com/psalm/psalm-vscode-plugin)) 

## Example

In order to show how code would look with these attributes, we can look at the following example. This is how a class looks like with the current annotations:

```php
<?php

class ArrayAdder
{
    /** @var array<string>  */
    private array $result;

    /**
     * @param array<string> $array1 the first array
     * @param array<string> $array2 the second array
     * @return array<string>
     */
    public function addArrays(array $array1, array $array2): array
    {
        $this->result = $array1 + $array2;
        return $this->result;
    }
}
```

And this is how it would look like using the new attributes:

```php
<?php

use PhpStaticAnalysis\Attributes\Type;
use PhpStaticAnalysis\Attributes\Param;
use PhpStaticAnalysis\Attributes\Returns;

class ArrayAdder
{
    #[Type('array<string>')]
    private array $result;

    #[Param(array1: 'array<string>')] // the first array
    #[Param(array2: 'array<string>')] // the second array
    #[Returns('array<string>')]
    public function addArrays(array $array1, array $array2): array
    {
        $this->array = $array1 + $array2;
        return $this->array;
    }
}
```

## Installation

To use these attributes, require this library in Composer:

```
composer require php-static-analysis/attributes
```

And then install any needed extensions/plugins for the tools that you use.

## List of implemented attributes

These are the available attributes and their corresponding PHPDoc annotations:

| Attribute                                             | PHPDoc Annotations        |
|-------------------------------------------------------|---------------------------|
| [Deprecated](doc/Deprecated.md)                       | `@deprecated`             |
| [Internal](doc/Internal.md)                           | `@internal`               |
| [IsReadOnly](doc/IsReadOnly.md)                       | `@readonly`               |
| [Method](doc/Method.md)                               | `@method`                 |
| [Mixin](doc/Mixin.md)                                 | `@mixin`                  |
| [Param](doc/Param.md)                                 | `@param`                  |
| [Property](doc/Property.md)                           | `@property` `@var`        |
| [PropertyRead](doc/PropertyRead.md)                   | `@property-read`          |
| [PropertyWrite](doc/PropertyWrite.md)                 | `@property-write`         |
| [Returns](doc/Returns.md)                             | `@return`                 |
| [Template](doc/Template.md)                           | `@template`               |
| [TemplateContravariant](doc/TemplateContravariant.md) | `@template-contravariant` |
| [TemplateCovariant](doc/TemplateCovariant.md)         | `@template-covariant`     |
| [Type](doc/Type.md)                                   | `@var` `@return`          |

