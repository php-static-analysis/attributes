<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS_CONSTANT |
    Attribute::TARGET_PROPERTY
)]
final class Type
{
    public function __construct(
        string $type
    ) {
    }
}
