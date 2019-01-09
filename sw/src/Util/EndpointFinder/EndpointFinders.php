<?php declare(strict_types=1);

namespace Sw\Util\EndpointFinder;

use Sw\Adapter\View\ActionInterface;
use Sw\Adapter\View\ControllerInterface;

class EndpointFinders
{
    /** @var null|EndpointFinderInterface */
    private $controllerEndpointFinder;
    /** @var null|EndpointFinderInterface */
    private $actionEndpointFinder;

    /**
     * EndpointFinders constructor.
     * @param EndpointFinderInterface $controllerEndpointFinder
     * @param EndpointFinderInterface $actionEndpointFinder
     */
    public function __construct(
        EndpointFinderInterface $controllerEndpointFinder = null,
        EndpointFinderInterface $actionEndpointFinder = null
    ) {
        $this->controllerEndpointFinder = $controllerEndpointFinder;
        $this->actionEndpointFinder = $actionEndpointFinder;
    }

    /**
     * @param string $type
     * @return null|EndpointFinderInterface
     */
    public function getForType(string $type): ?EndpointFinderInterface
    {
        switch ($type) {
            case ControllerInterface::class:
                return $this->getControllerEndpointFinder();
            case ActionInterface::class:
                return $this->getActionEndpointFinder();
        }

        return null;
    }

    /**
     * @return null|EndpointFinderInterface
     */
    public function getControllerEndpointFinder(): ?EndpointFinderInterface
    {
        return $this->controllerEndpointFinder;
    }

    /**
     * @return null|EndpointFinderInterface
     */
    public function getActionEndpointFinder(): ?EndpointFinderInterface
    {
        return $this->actionEndpointFinder;
    }
}
