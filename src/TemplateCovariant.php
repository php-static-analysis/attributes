<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class TemplateCovariant
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $of = null,
    ) {
    }
}
