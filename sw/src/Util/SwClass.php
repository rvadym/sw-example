<?php declare(strict_types=1);

namespace Sw\Util;

use Calcinai\Strut\Definitions\QueryParameterSubSchema;
use Calcinai\Strut\Definitions\Schema;
use Calcinai\Strut\Definitions\Schema\Properties\Properties;
use ReflectionClass;
use ReflectionProperty;
use ReflectionMethod;
use ReflectionException;
use ReflectionParameter;
use Exception;
use Sw\Adapter\View\ActionInterface;
use Sw\Adapter\View\ControllerInterface;
use Sw\Application\CommandQueryInterface;
use Sw\Util\Annotation\SwCommandQueryAnnotation;
use Sw\Util\EndpointFinder\EndpointFinderInterface;
use Sw\Util\EndpointFinder\EndpointFinders;
use Sw\Util\EndpointFinder\QueryFinder;

class SwClass
{
    /** @var string */
    private $class;
    /** @var string */
    private $type;
    /** @var EndpointFinderInterface  */
    private $endpointFinder;
    /** @var QueryFinder  */
    private $queryFinder;

    /**
     * SwClass constructor.
     * @param string $class
     * @param EndpointFinders $endpointFinders
     * @throws Exception
     * @throws ReflectionException
     */
    public function __construct(
        string $class,
        EndpointFinders $endpointFinders
    ) {
        $this->setClassAndType($class);
        $this->setEndpointFinder($endpointFinders);
        $this->queryFinder = new QueryFinder();
    }

    /**
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function getReflection()
    {
        static $reflection;

        if (is_null($reflection)) {
            $reflection = new ReflectionClass($this->class);
        }

        return $reflection;
    }

    /**
     * @param string $propertyName
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function getPropertyReflection(string $propertyName)
    {
        static $reflections = [];

        if (empty($reflections[$propertyName])) {
            $reflections[$propertyName] = new ReflectionProperty($this->class, $propertyName);
        }

        return $reflections[$propertyName];
    }

    /**
     * @param string $methodName
     * @return mixed
     * @throws ReflectionException
     */
    public function getMethodReflection(string $methodName)
    {
        static $reflections = [];

        if (empty($reflections[$methodName])) {
            $reflections[$methodName] = new ReflectionMethod($this->class, $methodName);
        }

        return $reflections[$methodName];
    }

    /**
     * @param ReflectionMethod $method
     * @return MethodSignature
     */
    protected function getMethodSignature(ReflectionMethod $method): MethodSignature
    {
        static $signatures = [];

        if (empty($signatures[$method->getName()])) {
            $signatures[$method->getName()] = new MethodSignature(
                $method->getParameters()
            );
        }

        return $signatures[$method->getName()];
    }

    /**
     * @return SwEndpoint[]
     */
    public function getEndpoints(): array
    {
        /** @var SwEndpoint[] $swEndpoints */
        $swEndpoints = $this->endpointFinder->find($this);

        /** @var SwEndpoint $swEndpoint */
        foreach ($swEndpoints as $swEndpoint) {
            $this->addCommandQueryParameters($swEndpoint);
        }

        return $swEndpoints;
    }

    protected function addCommandQueryParameters(SwEndpoint $swEndpoint): void
    {
        /** @var null|ReflectionClass $commandQuery */
        $commandQuery = $this->getCommandQuery(
            $this->getMethodSignature(
                $swEndpoint->getReflectionMethod()
            )
        );

        if ($commandQuery) {
            /** @var ReflectionProperty[] $properties */
            $properties = $this->getAllProperties($commandQuery);

            /** @var ReflectionProperty $property */
            foreach ($properties as $property) {
                /** @var SwCommandQueryAnnotation $annot */
                $annot = $this->queryFinder->find($property);

                $swEndpoint->addParameters(
                    QueryParameterSubSchema::create()
                        ->setName($property->getName())
                        ->setDescription($annot->getDescription())
                        ->setRequired($annot->isRequired())
                        ->setType($annot->getType())
                        ->setFormat($annot->getFormat())
                );
            }
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @return ReflectionProperty[]
     */
    protected function getAllProperties(ReflectionClass $reflectionClass): array
    {
        $properties = $reflectionClass->getProperties();
        $parentClass = $reflectionClass->getParentClass();

        if ($parentClass) {
            $parentProperties = $this->getAllProperties($parentClass);

            $properties = array_merge($properties, $parentProperties);
        }

        return $properties;
    }

    protected function getCommandQuery(MethodSignature $signature): ?ReflectionClass
    {
        /** @var ReflectionParameter[] $methodParameters */
        $methodParameters = $signature->getParameters();

        foreach ($methodParameters as $methodParameter) {
            /** @var ReflectionClass $parameterClass */
            $parameterClass = $methodParameter->getClass();

            if ($parameterClass->implementsInterface(CommandQueryInterface::class)) {
                return $parameterClass;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public function getDefinitionName(): string
    {
        return 'The Definition, Take from controller';
    }

    /**
     * @return Schema
     * @throws Exception
     */
    public function getDefinition(): Schema
    {
        $pet = Schema::create()
            ->addRequired('id')
            ->addRequired('name')

            ->setProperties(
                Properties::create()
                    ->set(
                        'id',
                        Schema::create()
                            ->setType('integer')
                            ->setFormat('int64')
                    )
                    ->set(
                        'name',
                        Schema::create()
                            ->setType('string')
                    )
                    ->set(
                        'tag',
                        Schema::create()
                            ->setType('string')
                    )
            );

        return Schema::create()
            ->setType('array')
            ->setItems($pet);
    }

    /**
     * @param string $class
     * @throws Exception
     * @throws ReflectionException
     */
    protected function setClassAndType(string $class): void
    {
        $isClassSupported = 0;
        $this->class = $class; // to be used by reflections methods

        $supportedInterfaces = [
            ActionInterface::class,
            ControllerInterface::class,
        ];

        foreach ($supportedInterfaces as $supportedInterface) {
            if ($this->getReflection()->implementsInterface($supportedInterface)) {
                $isClassSupported++;
            }
        }

        if ($isClassSupported !== 1) {
            throw new Exception(sprintf(
                'Class "%s" must implement one of supported interfaces "%s".',
                $class,
                implode(',', $supportedInterfaces)
            ));
        }

        $this->type = $supportedInterface ?? null;
    }

    /**
     * @param EndpointFinders $endpointFinders
     * @throws Exception
     */
    protected function setEndpointFinder(EndpointFinders $endpointFinders): void
    {
        $pathFinder = $endpointFinders->getForType($this->type);

        if ($pathFinder) {
            $this->endpointFinder = $pathFinder;
        } else {
            throw new Exception(sprintf(
                'No proper pathfinder found in configuration for type "%s".',
                $this->type
            ));
        }
    }
}
