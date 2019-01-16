<?php declare(strict_types=1);

namespace Sw\Util\Annotation;

use Doctrine\Common\Annotations;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotations()
 * @Target({"PROPERTY"})
 */
class SwViewModelPropertyAnnotation
{
    /** @var string */
    private $description;
    /** @var string */
    private $type;
    /** @var string */
    private $format;
    /** @var bool */
    private $required;

    /**
     * SwEndpoint constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->description = $values['description'] ?? '-no-description-';
        $this->type = $values['type'] ?? '-no-type-';
        $this->format = $values['format'] ?? '-no-format';
        $this->required = $values['required'] ?? true;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}
