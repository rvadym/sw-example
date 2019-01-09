<?php declare(strict_types=1);

namespace Sw\Util\EndpointFinder;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use ReflectionMethod;
use Sw\Util\Annotation\SwEndpointAnnotation;
use Sw\Util\SwClass;
use Sw\Util\SwEndpoint;

class ControllerMethodEndpointFinder implements EndpointFinderInterface
{
    /** @var AnnotationReader */
    private $reader;

    /**
     * ControllerMethodEndpointFinder constructor.
     * @param Reader|null $reader
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(Reader $reader = null)
    {
        $this->reader = $reader ?? new AnnotationReader();
    }

    /** {@inheritdoc} */
    public function find(SwClass $swClass): array
    {
        $methods = $swClass->getReflection()->getMethods(ReflectionMethod::IS_PUBLIC);

        /** @var SwEndpoint[] $swEndpoints */
        $swEndpoints = [];

        /** @var ReflectionMethod $method */
        foreach ($methods as $method) {
            $endpointAnnotation = $this->getEndpointAnnotation($method);

            $swEndpoints[$method->getName()] = new SwEndpoint(
                $endpointAnnotation->getPath(),
                $endpointAnnotation->getMethod(),
                $endpointAnnotation->getSummary(),
                $endpointAnnotation->getOperationId(),
                $endpointAnnotation->getTag()
            );
        }

        return $swEndpoints;
    }

    /**
     * @param ReflectionMethod $method
     * @return null|object
     */
    protected function getEndpointAnnotation(ReflectionMethod $method): ?SwEndpointAnnotation
    {
        return $this->reader->getMethodAnnotation(
            $method,
            SwEndpointAnnotation::class
        );
    }

}
