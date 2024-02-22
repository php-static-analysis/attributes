<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS
)]
final class TemplateExtends
{
    public function __construct(
        string $class
    ) {
    }
}
