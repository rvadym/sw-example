<?php declare(strict_types=1);

namespace Sw;

use Calcinai\Strut\Definitions\Definitions;
use Calcinai\Strut\Definitions\Info;
use Calcinai\Strut\Definitions\License;
use Calcinai\Strut\Definitions\Paths;
use Calcinai\Strut\Swagger;
use Sw\Util\ClassFinder;
use Sw\Util\SwClass;
use Sw\Util\SwEndpoint;

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

    /**
     * @return Swagger
     * @throws \Exception
     */
    public function getSwagger(): Swagger
    {
        $classes = $this->findPathsClasses(
            $this->config->getPathsNamespaces()
        );

        $swagger = $this->createMainSwagger();
        $paths = new Paths();
        $definitions = new Definitions();

        foreach ($classes as $class) {
            $this->addInfoForClass($class, $paths, $definitions);
        }

        $swagger->setPaths($paths);
        $swagger->setDefinitions($definitions);

        return $swagger;
    }

    /**
     * @param array $pathsNamespaces
     * @return array
     * @throws \Exception
     */
    protected function findPathsClasses(array $pathsNamespaces): array
    {
        $classes = [];

        foreach ($pathsNamespaces as $namespace) {
            $namespaceClasses = $this->getClassFinder()->getClassesByNamespace($namespace);

            $classes = array_merge($classes, $namespaceClasses);
        }

        return $classes;
    }

    /**
     * @return ClassFinder
     * @throws \Exception
     */
    protected function getClassFinder(): ClassFinder
    {
        /** @var ClassFinder */
        static $classFinder;

        if (!$classFinder instanceof ClassFinder) {
            $classFinder = new ClassFinder($this->config->getAutoloadPath());
        }

        return $classFinder;
    }

    /**
     * @return Swagger
     */
    protected function createMainSwagger(): Swagger
    {
        $swagger = Swagger::create();

        $swagger->setInfo(
                Info::create()
                    ->setTitle($this->config->getApiTitle())
                    ->setVersion($this->config->getApiVersion())
                    ->setLicense(
                        License::create()
                            ->setName($this->config->getApiLicense())
                    )
            );

        $swagger->setHost($this->config->getApiHost());
        $swagger->setBasePath($this->config->getApiBasePath());

        foreach ($this->config->getApiSchemes() as $scheme) {
            $swagger->addScheme($scheme);

        }

        $swagger->setConsumes($this->config->getApiConsumes());
        $swagger->setProduces($this->config->getApiProduces());

        return $swagger;
    }

    /**
     * @param string $class
     * @param Paths $paths
     * @param Definitions $definitions
     * @throws \Exception
     */
    protected function addInfoForClass(string $class, Paths $paths, Definitions $definitions): void
    {
        /** @var SwClass $swClass */
        $swClass = new SwClass(
            $class,
            $this->config->getEndpointFinders()
        );

        $endpoints = $swClass->getEndpoints();

        /** @var SwEndpoint $endpoint */
        foreach ($endpoints as $endpoint) {
            $paths->set(
                $endpoint->getEndpoint(),
                $endpoint->getPathItem()
            );
        }


//        $definitions->set(
//            $swClass->getDefinitionName(),
//            $swClass->getDefinition()
//        );
    }
}
