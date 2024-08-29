<?php

namespace Seed;

class Utils
{
    static public function getDifferentPaths($pathA, $pathB): array
    {
        if (is_string($pathA)) {
            return $pathA === $pathB ? [] : [$pathA];
        }
        $result = [];
        foreach ($pathA as $subDirectoryA => $subPathA) {
            $result = [
                ...$result,
                ...array_map(
                    fn($path) => is_string($subPathA) ? $path : $subDirectoryA . '/' . $path,
                    self::getDifferentPaths($subPathA, $pathB[$subDirectoryA] ?? null),
                ),
            ];
        }
        return $result;
    }
}
