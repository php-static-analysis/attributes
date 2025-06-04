<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class TemplateUse
{
    /**
     * @var string[]
     */
    public readonly array $traits;

    public function __construct(string ...$traits)
    {
        $this->traits = $traits;
    }
}
