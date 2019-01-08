<?php declare(strict_types=1);

namespace Api\Application\ViewTransformer\Article;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;
use Sw\Application\ViewTransformerInterface;

interface ArticlePaginatedListViewTransformerInterface extends ViewTransformerInterface
{
    /**
     * @param ArticlePaginatedListQuery $commandQuery
     * @return ArticlePaginatedListViewModel
     */
    public function execute(ArticlePaginatedListQuery $commandQuery): ArticlePaginatedListViewModel;
}
