<?php declare(strict_types=1);

namespace Api\Application\UseCase\Article;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\UseCase\UseCaseInterface;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;

interface ArticlePaginatedListUseCaseInterface extends UseCaseInterface
{
    /**
     * @param ArticlePaginatedListQuery $commandQuery
     * @return ArticlePaginatedListViewModel
     */
    public function execute(ArticlePaginatedListQuery $commandQuery): ArticlePaginatedListViewModel;
}
