<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class PropertyRead
{
    /**
     * @var string[]
     */
    public readonly array $properties;

    public function __construct(string ...$properties)
    {
        $this->properties = $properties;
    }
}
