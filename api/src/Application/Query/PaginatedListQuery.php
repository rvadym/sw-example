<?php declare(strict_types=1);

namespace Api\Application\Query;

use Sw\Application\CommandQueryInterface;
use Sw\Util\Annotation\SwCommandQueryAnnotation as SwCommandQuery;

class PaginatedListQuery implements CommandQueryInterface
{
    /**
     * @var int
     *
     * @SwCommandQuery(
     *     description="Page of results.",
     *     type="integer",
     *     format="int64",
     *     required=false,
     * )
     */
    private $page = 1;

    /**
     * @var int
     *
     * @SwCommandQuery(
     *     description="Quantity of results on page.",
     *     type="integer",
     *     format="int64",
     *     required=false,
     * )
     */
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
