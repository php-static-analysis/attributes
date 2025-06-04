<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class Method
{
    /**
     * @var string[]
     */
    public readonly array $methods;

    public function __construct(string ...$methods)
    {
        $this->methods = $methods;
    }
}
