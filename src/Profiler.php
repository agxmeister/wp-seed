<?php

namespace Seed;

class Profiler
{
    private array $checkpoints = [];

    private ?string $currentCheckpointName = null;

    public function check($name): void
    {
        $this->finalize();
        $this->checkpoints[$name] = [
            'start' => microtime(true),
            'end'   => null,
        ];
        $this->currentCheckpointName = $name;
    }

    public function finalize(): void
    {
        if (!is_null($this->currentCheckpointName)) {
            $this->checkpoints[$this->currentCheckpointName]['end'] = microtime(true);
        }
    }

    public function report(): string
    {
        $this->finalize();
        $firstCheckpoint = count($this->checkpoints) > 0
            ? $this->checkpoints[array_key_first($this->checkpoints)]
            : null;
        $lastCheckpoint = count($this->checkpoints) > 0
            ? $this->checkpoints[array_key_last($this->checkpoints)]
            : null;
        return json_encode([
            'checks' => array_map(
                fn($checkpoint) => $checkpoint['end'] - $checkpoint['start'],
                $this->checkpoints,
            ),
            'total' => !is_null($firstCheckpoint) && !is_null($lastCheckpoint)
                ? $lastCheckpoint['end'] - $firstCheckpoint['start']
                : 0,
        ]);
    }

    public function dump($path): void
    {
        file_put_contents($path, $this->report());
    }
}
