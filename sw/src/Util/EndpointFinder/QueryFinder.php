<?php declare(strict_types=1);

namespace Sw\Util\EndpointFinder;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Sw\Util\Annotation\SwCommandQueryAnnotation;
use ReflectionProperty;

class QueryFinder
{
    /** @var AnnotationReader */
    private $reader;

    /**
     * QueryFinder constructor.
     * @param Reader|null $reader
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function __construct(Reader $reader = null)
    {
        $this->reader = $reader ?? new AnnotationReader();
    }

    /**
     * @param ReflectionProperty $property
     * @return SwCommandQueryAnnotation
     */
    public function find(ReflectionProperty $property): SwCommandQueryAnnotation
    {
        return $this->reader->getPropertyAnnotation(
            $property,
            SwCommandQueryAnnotation::class
        );
    }
}
