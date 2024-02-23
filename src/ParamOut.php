<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_METHOD |
    Attribute::TARGET_FUNCTION |
    Attribute::TARGET_PARAMETER |
    Attribute::IS_REPEATABLE
)]
final class ParamOut
{
    public function __construct(
        string ...$params
    ) {
    }
}
