<?php declare(strict_types=1);

namespace Api\Application\ViewModel;

abstract class Collection
{
    /**
     * Collection constructor.
     * @param array $collection
     * @throws \Exception
     */
    public function __construct(array $collection)
    {
        foreach ($collection as $item) {
            $this->validate($item);
        }
    }

    /**
     * @param $item
     * @throws \Exception
     */
    abstract protected function validate($item): void;
}
