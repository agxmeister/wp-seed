<?php

namespace Seed;

readonly class Setup
{
    public function __construct(private File $file, private Tools $tools, private string $wpCliUrl)
    {
    }

    public function getWpCli(): void
    {
        $this->file->getByUrl($this->wpCliUrl, $this->tools->getWpCliPath());
    }
}
