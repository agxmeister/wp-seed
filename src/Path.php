<?php

namespace Seed;

readonly class Path
{
    public function getStructure(string $path): array|string
    {
        if (is_file($path)) {
            return basename($path);
        }
        $result = [];
        $handler = opendir($path);
        while (($entry = readdir($handler)) !== false) {
            if ($entry === "." || $entry === "..") {
                continue;
            }
            $result[$entry] = $this->getStructure($path . DIRECTORY_SEPARATOR . $entry);
        }
        return $result;
    }
}
