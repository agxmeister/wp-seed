<?php

namespace Seed;

interface PackageFetcher
{
    public function getByUrl(string $url, string $fileName): string;
}
