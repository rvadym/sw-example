<?php declare(strict_types=1);

namespace Sw\Util;

use Calcinai\Strut\Definitions\Schema;
use Calcinai\Strut\Definitions\Schema\Properties\Properties;
use ReflectionClass;
//use ReflectionProperty;
//use ReflectionMethod;
use ReflectionException;
use Exception;
use Sw\Adapter\View\ActionInterface;
use Sw\Adapter\View\ControllerInterface;
use Sw\Util\EndpointFinder\EndpointFinderInterface;
use Sw\Util\EndpointFinder\EndpointFinders;

class SwClass
{
    /** @var string */
    private $class;
    /** @var string */
    private $type;
    /** @var EndpointFinderInterface  */
    private $endpointFinder;

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
     * @return SwEndpoint[]
     * @throws Exception
     */
    public function getEndpoints(): array
    {
        /** @var SwEndpoint[] $swEndpoints */
        $swEndpoints = $this->endpointFinder->find($this);

        /** @var SwEndpoint $swEndpoint */
        foreach ($swEndpoints as $swEndpoint) {
            $classMethod = new SwClassMethod(
                $swEndpoint
            );

            $classMethod->process();
        }

        return $swEndpoints;
    }

//    /**
//     * @return string
//     */
//    public function getDefinitionName(): string
//    {
//        return 'The Definition, Take from controller';
//    }
//
//    /**
//     * @return Schema
//     * @throws Exception
//     */
//    public function getDefinition(): Schema
//    {
//        $pet = Schema::create()
//            ->addRequired('id')
//            ->addRequired('name')
//
//            ->setProperties(
//                Properties::create()
//                    ->set(
//                        'id',
//                        Schema::create()
//                            ->setType('integer')
//                            ->setFormat('int64')
//                    )
//                    ->set(
//                        'name',
//                        Schema::create()
//                            ->setType('string')
//                    )
//                    ->set(
//                        'tag',
//                        Schema::create()
//                            ->setType('string')
//                    )
//            );
//
//        return Schema::create()
//            ->setType('array')
//            ->setItems($pet);
//    }

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

//    /**
//     * @param string $propertyName
//     * @return ReflectionClass
//     * @throws ReflectionException
//     */
//    public function getPropertyReflection(string $propertyName)
//    {
//        static $reflections = [];
//
//        if (empty($reflections[$propertyName])) {
//            $reflections[$propertyName] = new ReflectionProperty($this->class, $propertyName);
//        }
//
//        return $reflections[$propertyName];
//    }

//    /**
//     * @param string $methodName
//     * @return mixed
//     * @throws ReflectionException
//     */
//    public function getMethodReflection(string $methodName)
//    {
//        static $reflections = [];
//
//        if (empty($reflections[$methodName])) {
//            $reflections[$methodName] = new ReflectionMethod($this->class, $methodName);
//        }
//
//        return $reflections[$methodName];
//    }
}
