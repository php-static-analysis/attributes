<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class RequireImplements
{
    /**
     * @var string[]
     */
    public readonly array $interfaces;

    public function __construct(string ...$interfaces)
    {
        $this->interfaces = $interfaces;
    }
}
