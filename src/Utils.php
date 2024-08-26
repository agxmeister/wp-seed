<?php

namespace Seed;

class Utils
{
    static public function getDifferentPaths($pathA, $pathB): array
    {
        if (is_array($pathA)) {
            $result = [];
            foreach ($pathA as $subDirectoryA => $subPathA) {
                $result = [
                    ...$result,
                    ...array_map(
                        fn($path) => is_string($subDirectoryA) ? $subDirectoryA . '/' . $path : $path,
                        self::getDifferentPaths($subPathA, $pathB[$subDirectoryA] ?? null),
                    ),
                ];
            }
            return $result;
        }
        if ($pathA === $pathB) {
            return [];
        }
        return [$pathA];
    }
}
