<?php declare(strict_types=1);

namespace Api\Application\ViewModel;

class PaginationViewModel
{
    /** @var int */
    private $total = 0;
    /** @var int */
    private $current = 0;

    public function __construct(int $total, int $current)
    {
        $this->total = $total;
        $this->current = $current;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getCurrent(): int
    {
        return $this->current;
    }
}
