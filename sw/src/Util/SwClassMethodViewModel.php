<?php declare(strict_types=1);

namespace Sw\Util;

use ReflectionClass;
use ReflectionProperty;
use ReflectionException;
use Sw\Util\EndpointFinder\ViewModelFinder;
use Exception;
use Calcinai\Strut\Definitions\Response;
use Calcinai\Strut\Definitions\Schema;
use Calcinai\Strut\Definitions\Schema\Properties\Properties;
use ReflectionType;
use Sw\Application\ViewModelInterface;
use Sw\Util\Annotation\SwViewModelPropertyAnnotation;

class SwClassMethodViewModel
{
    use MergedPropertiesTrait;

    /** @var SwEndpoint  */
    private $swEndpoint;
    /** @var ViewModelFinder  */
    private $viewModelFinder;
    /** @var null|ReflectionClass */
    private $class;
    /** @var null|ReflectionType  */
    private $returnType;

    /**
     * SwClassMethodViewModel constructor.
     * @param SwEndpoint $swEndpoint
     * @param null|ReflectionType $returnType
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(
        SwEndpoint $swEndpoint,
        ?ReflectionType $returnType
    ) {
        $this->swEndpoint = $swEndpoint;
        $this->returnType = $returnType;
        $this->viewModelFinder = new ViewModelFinder(); // TODO dependency
    }

    /**
     * @throws Exception
     * @throws ReflectionException
     */
    public function process(): void
    {
        if (is_null($this->returnType)) {
            return;
        }

        $this->class = $this->getClassReflection($this->returnType);

        if ($this->class) {
            $this->getSchemaForViewModel(
                $this->class,
                $this->swEndpoint
            );
        }
    }

    /**
     * @param ReflectionType $returnType
     * @return null|ReflectionClass
     * @throws Exception
     * @throws ReflectionException
     */
    protected function getClassReflection(ReflectionType $returnType): ?ReflectionClass
    {
        if ($returnType->allowsNull()) {
            throw new Exception('View model should now be null.');
        }

        if ($returnType->isBuiltin()) {
            throw new Exception('View model should now be custom class.');
        }

        $viewModelClass = $returnType->getName();

        if (!class_exists($viewModelClass)) {
            throw new Exception(sprintf('Class "%s" does not exist', $viewModelClass));
        }

        $reflection = new ReflectionClass($viewModelClass);

        if ($reflection->implementsInterface(ViewModelInterface::class)) {
            return $reflection;
        }

        return null;
    }

    /**
     * @param ReflectionClass $class
     * @param SwEndpoint $swEndpoint
     * @throws Exception
     */
    protected function getSchemaForViewModel(ReflectionClass $class, SwEndpoint $swEndpoint)
    {
        $responseAnnotation = $this->viewModelFinder->findResponse($class);
        $response = Response::create();
        $response->setDescription(
            $responseAnnotation->getDescription()
        );

        $swEndpoint->addResponse(
            $responseAnnotation->getCode(),
            $response
        );

        $response->setSchema(
            $this->addProperties($class)
        );
    }

    /**
     * @param ReflectionClass $viewModel
     * @return Schema
     * @throws Exception
     */
    protected function addProperties(ReflectionClass $viewModel): Schema
    {
        /** @var ReflectionProperty[] $properties */
        $properties = $this->getAllProperties($viewModel);

        /** @var Properties $schemaProperties */
        $schemaProperties = Properties::create();

        /** @var Schema $mainSchema */
        $mainSchema = Schema::create();
        $mainSchema->setProperties($schemaProperties);

        /** @var ReflectionProperty $property */
        foreach ($properties as $property) {
            /** @var SwViewModelPropertyAnnotation $annotation */
            $annotation = $this->viewModelFinder->findProperties($property);

            if ($annotation->isRequired()) {
                $mainSchema->addRequired(
                    $property->getName()
                );
            }

            $schemaProperties->set(
                $property->getName(),
                $this->getSchemaProperty($annotation)
            );
        }

        return $mainSchema;
    }

    /**
     * @param SwViewModelPropertyAnnotation $annotation
     * @return Schema
     */
    protected function getSchemaProperty(SwViewModelPropertyAnnotation $annotation): Schema
    {
        $schema = Schema::create();

        $schema
            ->setDescription($annotation->getDescription())
            ->setType($annotation->getType())
            ->setFormat($annotation->getFormat());


        return $schema;
    }
}
