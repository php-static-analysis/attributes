<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class Mixin
{
    /**
     * @var string[]
     */
    public readonly array $classes;

    public function __construct(string ...$classes)
    {
        $this->classes = $classes;
    }
}
