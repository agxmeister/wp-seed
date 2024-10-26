<?php

namespace Seed;

readonly class WpCli
{
    public function __construct(private string $url, private File $file, private Destination $destination)
    {
    }

    public function install(): void
    {
        $this->file->getByUrl($this->url, $this->destination->getWpCliPath());
    }
}
