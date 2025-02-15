<?php

namespace Juampi92\Phecks\Domain\DTOs;

class FileMatch
{
    public string $file;

    public ?int $line = null;

    public ?string $context = null;

    public function __construct(
        string $file,
        ?int $line = null,
        ?string $context = null
    ) {
        $this->file = $file;
        $this->line = $line;
        $this->context = $context;
    }
}
