<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_METHOD |
    Attribute::TARGET_FUNCTION |
    Attribute::IS_REPEATABLE
)]
final class Throws
{
    /**
     * @var string[]
     */
    public readonly array $exceptions;

    public function __construct(string ...$exceptions)
    {
        $this->exceptions = $exceptions;
    }
}
