<?php declare(strict_types=1);

namespace Sw\Util\EndpointFinder;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Sw\Util\Annotation\SwViewModelAnnotation;
use Sw\Util\Annotation\SwViewModelPropertyAnnotation;
use ReflectionProperty;
use ReflectionClass;

class ViewModelFinder
{
    /** @var AnnotationReader */
    private $reader;

    /**
     * ViewModelFinder constructor.
     * @param Reader|null $reader
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(Reader $reader = null)
    {
        $this->reader = $reader ?? new AnnotationReader();
    }

    /**
     * @param ReflectionClass $property
     * @return SwViewModelAnnotation
     */
    public function findResponse(ReflectionClass $property): SwViewModelAnnotation
    {
        return $this->reader->getClassAnnotation(
            $property,
            SwViewModelAnnotation::class
        );
    }

    /**
     * @param ReflectionProperty $property
     * @return SwViewModelPropertyAnnotation
     */
    public function findProperties(ReflectionProperty $property): SwViewModelPropertyAnnotation
    {
        return $this->reader->getPropertyAnnotation(
            $property,
            SwViewModelPropertyAnnotation::class
        );
    }
}
