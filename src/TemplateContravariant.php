<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::TARGET_METHOD |
    Attribute::TARGET_FUNCTION |
    Attribute::IS_REPEATABLE
)]
final class TemplateContravariant
{
    public function __construct(
        string $name,
        ?string $of = null
    ) {
    }
}
