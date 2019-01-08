<?php declare(strict_types=1);

namespace Sw\Util;

use Composer\Autoload\ClassLoader;
use Gears\ClassFinder as GearsClassFinder;

class ClassFinder
{
    /** @var ClassLoader  */
    private $composer;
    /** @var GearsClassFinder  */
    private $finder;

    /**
     * ClassFinder constructor.
     * @param string $autoloadPath
     * @throws \Exception
     */
    public function __construct(string $autoloadPath)
    {
        $this->composer = require $autoloadPath;

        if (empty($this->composer)) {
            throw new \Exception('No composer autoload configured.');
        }

        $this->finder = new GearsClassFinder($this->composer);
    }

    /**
     * @param string $namespace
     * @return array
     */
    public function getClassesByNamespace(string $namespace): array
    {
        return $this->finder->namespace($namespace)->search();
    }
}
