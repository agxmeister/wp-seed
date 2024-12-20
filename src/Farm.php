<?php

namespace Seed;

readonly class Farm
{
    public function __construct(private string $basePath, private Package $package, private Fetcher $fetcher)
    {
    }

    public function getSitePath($name): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $name;
    }

    public function deploy(string $name, ?string $version, bool $cleanup = true): void
    {
        if ($cleanup) {
            $this->cleanup($name);
        }
        $corePackagePath = $this->fetcher->getCore($version);
        $destinationPath = $this->getSitePath($name);
        $this->package->extract($corePackagePath, $destinationPath);
        $this->move($name);
    }

    public function configure($name, $database, $username, $password, $hostname): void
    {
        $pathSrc = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wp-config-sample.php';
        $pathDst = $this->basePath . DIRECTORY_SEPARATOR . $name . DIRECTORY_SEPARATOR . 'wp-config.php';
        file_put_contents(
            $pathDst,
            str_replace([
                'database_name_here',
                'username_here',
                'password_here',
                'localhost'
            ], [
                $database,
                $username,
                $password,
                $hostname,
            ], file_get_contents($pathSrc))
        );
        exec("rm -f $pathSrc");
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
