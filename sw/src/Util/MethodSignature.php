<?php declare(strict_types=1);

namespace Sw\Util;

class MethodSignature
{
    /** @var array */
    private $parameters;

    /**
     * MethodSignature constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }
}
