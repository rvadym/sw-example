<?php declare(strict_types=1);

namespace Sw\Util\Annotation;

use Doctrine\Common\Annotations;
use Doctrine\Common\Annotations\Annotation\Target;

/**
 * @Annotations()
 * @Target({"CLASS"})
 */
class SwViewModelAnnotation
{
    /** @var string */
    private $description;
    /** @var int */
    private $code;

    /**
     * SwEndpoint constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->description = $values['description'] ?? '-no-description-';
        $this->code = $values['code'] ?? 200;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }
}
