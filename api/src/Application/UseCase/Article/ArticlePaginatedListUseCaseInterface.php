<?php declare(strict_types=1);

namespace Api\Application\UseCase\Article;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;
use Sw\Application\UseCaseInterface;

interface ArticlePaginatedListUseCaseInterface extends UseCaseInterface
{
    /**
     * @param ArticlePaginatedListQuery $commandQuery
     * @return ArticlePaginatedListViewModel
     */
    public function execute(ArticlePaginatedListQuery $commandQuery): ArticlePaginatedListViewModel;
}
