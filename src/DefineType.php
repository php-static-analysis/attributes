<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class DefineType
{
    /**
     * @var string[]
     */
    public readonly array $types;

    public function __construct(string ...$types)
    {
        $this->types = $types;
    }
}
