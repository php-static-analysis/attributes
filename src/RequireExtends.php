<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS
)]
final class RequireExtends
{
    public function __construct(public readonly string $class)
    {
    }
}
