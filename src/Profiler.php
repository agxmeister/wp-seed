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
        return json_encode([
            'checks' => array_map(
                fn($checkpoint) => $checkpoint['end'] - $checkpoint['start'],
                $this->checkpoints,
            ),
            'total' => $this->getLastCheckpoint()['end'] - $this->getFirstCheckpoint()['start'],
        ]);
    }

    public function dump($path): void
    {
        file_put_contents($path, $this->report());
    }

    private function getFirstCheckpoint(): array
    {
        return $this->checkpoints[array_key_first($this->checkpoints)];
    }

    private function getLastCheckpoint(): array
    {
        return $this->checkpoints[array_key_last($this->checkpoints)];
    }
}
