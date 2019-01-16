<?php declare(strict_types=1);

namespace Sw\Util;

use Calcinai\Strut\Definitions\QueryParameterSubSchema;
use ReflectionClass;
use ReflectionProperty;
use ReflectionParameter;
use Sw\Application\CommandQueryInterface;
use Sw\Util\Annotation\SwCommandQueryAnnotation;
use Sw\Util\EndpointFinder\QueryFinder;

class SwClassMethodCommandQuery
{
    use MergedPropertiesTrait;

    /** @var SwEndpoint  */
    private $swEndpoint;
    /** @var ReflectionParameter[]  */
    private $parameters;
    /** @var QueryFinder  */
    private $queryFinder;
    /** @var null|ReflectionClass */
    private $class;

    /**
     * SwClassMethodCommandQuery constructor.
     * @param array $parameters
     * @param SwEndpoint $swEndpoint
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(
        array $parameters,
        SwEndpoint $swEndpoint
    ) {
        $this->parameters = $parameters;
        $this->swEndpoint = $swEndpoint;
        $this->queryFinder = new QueryFinder(); // TODO dependency
    }

    public function process(): void
    {
        $this->class = $this->getClassReflection($this->parameters);

        if ($this->class) {
            $this->getSchemaForProperties(
                $this->class,
                $this->swEndpoint
            );
        }
    }

    /**
     * @param array $parameters
     * @return null|ReflectionClass
     */
    protected function getClassReflection(array $parameters): ?ReflectionClass
    {
        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            /** @var ReflectionClass $parameterClass */
            $parameterClass = $parameter->getClass();

            if ($parameterClass->implementsInterface(CommandQueryInterface::class)) {
                return $parameterClass;
            }
        }

        return null;
    }

    protected function getSchemaForProperties(ReflectionClass $class, SwEndpoint $swEndpoint)
    {
        /** @var ReflectionProperty[] $properties */
        $properties = $this->getAllProperties($class);

        /** @var ReflectionProperty $property */
        foreach ($properties as $property) {
            /** @var SwCommandQueryAnnotation $annotation */
            $annotation = $this->queryFinder->find($property);

            $swEndpoint->addParameters(
                QueryParameterSubSchema::create()
                    ->setName($property->getName())
                    ->setDescription($annotation->getDescription())
                    ->setRequired($annotation->isRequired())
                    ->setType($annotation->getType())
                    ->setFormat($annotation->getFormat())
            );
        }
    }
}
