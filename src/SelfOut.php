<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_METHOD
)]
final class SelfOut
{
    public function __construct(public readonly string $type)
    {
    }
}
