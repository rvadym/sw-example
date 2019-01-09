<?php declare(strict_types=1);

namespace Sw\Util\Annotation;

use Doctrine\Common\Annotations;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotations()
 * @Target({"METHOD", "CLASS"})
 */
class SwEndpointAnnotation
{
    /** @var string */
    private $path;
    /** @var string */
    private $method;
    /** @var string */
    private $summary;
    /** @var string */
    private $operationId;
    /** @var string */
    private $tag;

    /**
     * SwEndpoint constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->path = $values['path'] ?? '-no-path-';
        $this->method = $values['method'] ?? '-no-method-';
        $this->summary = $values['summary'] ?? '-no-summary';
        $this->operationId = $values['operationId'] ?? '-no-operationId-';
        $this->tag = $values['tag'] ?? '-no-tag-';
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @return string
     */
    public function getOperationId(): string
    {
        return $this->operationId;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }
}
