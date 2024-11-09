<?php

namespace Seed;

class Profiler
{
    private $checks = [];

    private $currentCheckName = null;

    public function check($name): void
    {
        $this->finalize();
        $this->checks[$name] = [
            'start' => microtime(true),
            'end'   => null,
        ];
        $this->currentCheckName = $name;
    }

    public function finalize(): void
    {
        if (!is_null($this->currentCheckName)) {
            $this->checks[$this->currentCheckName]['end'] = microtime(true);
        }
    }

    public function dump($path): void
    {
        $this->finalize();
        file_put_contents($path, json_encode(array_map(
            fn($check) => $check['end'] - $check['start'],
            $this->checks,
        )));
    }
}
