<?php

namespace Seed;

readonly class WpCli
{
    public function __construct(private string $url, private File $file, private Tools $tools)
    {
    }

    public function install(): void
    {
        $this->file->getByUrl($this->url, $this->tools->getWpCliPath());
    }
}
