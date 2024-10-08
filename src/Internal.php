<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::TARGET_METHOD |
    Attribute::TARGET_FUNCTION |
    Attribute::TARGET_PROPERTY |
    Attribute::TARGET_CLASS_CONSTANT
)]
final class Internal
{
    public function __construct(
        ?string $namespace = null
    ) {
    }
}
