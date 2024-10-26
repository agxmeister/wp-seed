<?php

namespace Seed;

readonly class Destination
{
    public function __construct(private string $basePath)
    {
    }

    public function getWebPath($name): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $name;
    }

    public function getWpCliPath(): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'wp-cli.phar';
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

    public function configure($name, $database, $username, $password): void
    {
        $pathSrc = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wp-config-sample.php';
        $pathDst = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wp-config.php';
        file_put_contents(
            $pathDst,
            str_replace([
                'database_name_here',
                'username_here',
                'password_here',
            ], [
                $database,
                $username,
                $password,
            ], file_get_contents($pathSrc))
        );
        exec("rm -f $pathSrc");
    }
}
