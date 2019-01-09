<?php declare(strict_types=1);

namespace Sw;

use Sw\Util\EndpointFinder\EndpointFinders;

class SwConfig
{
    /** @var array */
    private $pathsNamespaces = [];
    /** @var string */
    private $autoloadPath;
    /** @var string */
    private $validationErrorViewModelClass;
    /** @var EndpointFinders  */
    private $endpointFinders;

    /* <<< Main Swagger configuration */
    /** @var string */
    private $apiTitle;
    /** @var string */
    private $apiVersion;
    /** @var string */
    private $apiLicense;
    /** @var string */
    private $apiHost;
    /** @var string */
    private $apiBasePath;
    /** @var array */
    private $apiSchemes;
    /** @var array */
    private $apiConsumes;
    /** @var array */
    private $apiProduces;
    /* >>> Main Swagger configuration */

    /**
     * SwConfig constructor.
     * @param array $pathsNamespaces
     * @param string $autoloadPath
     * @param string $validationErrorViewModelClass
     * @param EndpointFinders $endpointFinders
     * @param string $apiTitle
     * @param string $apiVersion
     * @param string $apiLicense
     * @param string $apiHost
     * @param string $apiBasePath
     * @param array $apiSchemes
     * @param array $apiConsumes
     * @param array $apiProduces
     */
    public function __construct(
        array $pathsNamespaces = [],
        string $autoloadPath,
        string $validationErrorViewModelClass,
        EndpointFinders $endpointFinders,
        string $apiTitle,
        string $apiVersion,
        string $apiLicense,
        string $apiHost,
        string $apiBasePath,
        array $apiSchemes,
        array $apiConsumes,
        array $apiProduces
    ) {
        $this->pathsNamespaces = $pathsNamespaces;
        $this->autoloadPath = $autoloadPath;
        $this->validationErrorViewModelClass = $validationErrorViewModelClass;
        $this->endpointFinders = $endpointFinders;
        $this->apiTitle = $apiTitle;
        $this->apiVersion = $apiVersion;
        $this->apiLicense = $apiLicense;
        $this->apiHost = $apiHost;
        $this->apiBasePath = $apiBasePath;
        $this->apiSchemes = $apiSchemes;
        $this->apiConsumes = $apiConsumes;
        $this->apiProduces = $apiProduces;
    }

    /**
     * @return EndpointFinders
     */
    public function getEndpointFinders(): EndpointFinders
    {
        return $this->endpointFinders;
    }

    /**
     * @return array
     */
    public function getApiProduces(): array
    {
        return $this->apiProduces;
    }

    /**
     * @return array
     */
    public function getApiConsumes(): array
    {
        return $this->apiConsumes;
    }

    /**
     * @return array
     */
    public function getApiSchemes(): array
    {
        return $this->apiSchemes;
    }

    /**
     * @return string
     */
    public function getApiBasePath(): string
    {
        return $this->apiBasePath;
    }

    /**
     * @return string
     */
    public function getApiHost(): string
    {
        return $this->apiHost;
    }

    /**
     * @return string
     */
    public function getApiLicense(): string
    {
        return $this->apiLicense;
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * @return string
     */
    public function getApiTitle(): string
    {
        return $this->apiTitle;
    }

    /**
     * @return array
     */
    public function getPathsNamespaces(): array
    {
        return $this->pathsNamespaces;
    }

    /**
     * @return string
     */
    public function getAutoloadPath(): string
    {
        return $this->autoloadPath;
    }

    /**
     * @return string
     */
    public function getValidationErrorViewModelClass(): string
    {
        return $this->validationErrorViewModelClass;
    }
}
