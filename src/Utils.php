<?php

namespace Seed;

class Utils
{
    static public function getDifferentPaths($pathA, $pathB)
    {
        if (is_array($pathA)) {
            $result = [];
            foreach ($pathA as $subDirectoryA => $subPathA) {
                $result = [...$result, ...self::getDifferentPaths($subPathA, $pathB[$subDirectoryA] ?? null)];
            }
            return $result;
        }
        if ($pathA === $pathB) {
            return [];
        }
        return [$pathA];
    }
}
