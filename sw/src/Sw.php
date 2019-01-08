<?php declare(strict_types=1);

namespace Sw;

use Sw\Util\ClassFinder;

class Sw
{
    /** @var SwConfig */
    private $config;

    /**
     * Sw constructor.
     * @param SwConfig $config
     */
    public function __construct(SwConfig $config)
    {
        $this->config = $config;
    }

    public function run(): void
    {
        $controllers = $this->findControllers(
            $this->config->getControllersNamespaces()
        );
    }

    /**
     * @param string[] $controllersNamespaces
     * @return array
     */
    protected function findControllers(array $controllersNamespaces): array
    {
        $classes = [];

        foreach ($controllersNamespaces as $controllersNamespace) {
            $namespaceControllers = $this->getClassFinder()->getClassesByNamespace($controllersNamespace);

            $classes = array_merge($classes, $namespaceControllers);
        }

        return $classes;
    }

    protected function getClassFinder(): ClassFinder
    {
        /** @var ClassFinder */
        static $classFinder;

        if (!$classFinder instanceof ClassFinder) {
            $classFinder = new ClassFinder($this->config->getAutoloadPath());
        }

        return $classFinder;
    }
}
