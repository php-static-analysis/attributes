<?php

declare(strict_types=1);

namespace PhpStaticAnalysis\Attributes;

use Attribute;

#[Attribute(
    Attribute::TARGET_CLASS |
    Attribute::IS_REPEATABLE
)]
final class ImportType
{
    /**
     * @var string[]
     */
    public readonly array $from;

    public function __construct(string ...$from)
    {
        $this->from = $from;
    }
}
