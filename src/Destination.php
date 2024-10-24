<?php

namespace Seed;

readonly class Destination
{
    public function __construct(private string $basePath)
    {
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function getPath($name): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $name;
    }

    public function cleanup($name): void
    {
        $path = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wordpress';
        exec("rm -rf $path");
    }

    public function move($name): void
    {
        $pathTo = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR;
        $pathFrom = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wordpress' . DIRECTORY_SEPARATOR . '*';
        exec("mv $pathFrom $pathTo");
        $pathToRemove = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wordpress';
        exec("rm -rf $pathToRemove");
    }
}
