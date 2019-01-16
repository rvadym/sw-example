<?php declare(strict_types=1);

namespace Sw\Util;

use ReflectionClass;
use ReflectionProperty;

trait MergedPropertiesTrait
{
    /**
     * Finds properties for class and all its parents.
     *
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
}
