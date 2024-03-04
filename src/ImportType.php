<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class ImportType
{
    public function __construct(
        string ...$from
    ) {
    }
}
