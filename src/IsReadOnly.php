<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_PROPERTY
)]
final class IsReadOnly
{
    public function __construct()
    {
    }
}
