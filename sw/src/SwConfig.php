<?php declare(strict_types=1);

namespace Sw;

class SwConfig
{
    /** @var array */
    private $controllersNamespaces = [];
    /** @var string */
    private $autoloadPath;

    /**
     * SwConfig constructor.
     * @param array $controllersNamespaces
     * @param string $autoloadPath
     */
    public function __construct(
        array $controllersNamespaces = [],
        string $autoloadPath
    ) {
        $this->controllersNamespaces = $controllersNamespaces;
        $this->autoloadPath = $autoloadPath;
    }

    /**
     * @return array
     */
    public function getControllersNamespaces(): array
    {
        return $this->controllersNamespaces;
    }

    /**
     * @return string
     */
    public function getAutoloadPath(): string
    {
        return $this->autoloadPath;
    }
}
