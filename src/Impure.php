<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_METHOD |
    Attribute::TARGET_FUNCTION
)]
final class Impure
{
    public function __construct()
    {
    }
}
