<?php declare(strict_types=1);

namespace Sw\Util\EndpointFinder;

use Sw\Util\SwClass;
use Sw\Util\SwEndpoint;

interface EndpointFinderInterface
{
    /**
     * @param SwClass $swClass
     * @return SwEndpoint[]
     */
    public function find(SwClass $swClass): array;
}
