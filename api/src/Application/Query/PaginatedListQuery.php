<?php declare(strict_types=1);

namespace Api\Application\Query;

use Sw\Application\CommandQueryInterface;

class PaginatedListQuery implements CommandQueryInterface
{
    /** @var int */
    private $page = 1;
    /** @var int */
    private $limit = 10;

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }
}
