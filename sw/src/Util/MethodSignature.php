<?php declare(strict_types=1);

namespace Sw\Util;

use ReflectionType;

class MethodSignature
{
    /** @var array */
    private $parameters;
    /** @var null|ReflectionType */
    private $returnType;

    /**
     * MethodSignature constructor.
     * @param array $parameters
     * @param null|ReflectionType $returnType
     */
    public function __construct(
        array $parameters,
        ?ReflectionType $returnType
    ) {
        $this->parameters = $parameters;
        $this->returnType = $returnType;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return null|ReflectionType
     */
    public function getReturnType(): ?ReflectionType
    {
        return $this->returnType;
    }
}
