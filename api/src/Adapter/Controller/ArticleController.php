<?php declare(strict_types=1);

namespace Api\Adapter\Controller;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\UseCase\Article\ArticlePaginatedListUseCaseInterface;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;
use Sw\Adapter\View\ControllerInterface;

class ArticleController implements ControllerInterface
{
    /**
     * @param ArticlePaginatedListQuery $query
     * @param ArticlePaginatedListUseCaseInterface $useCase
     * @return ArticlePaginatedListViewModel
     */
    public function list(ArticlePaginatedListQuery $query, ArticlePaginatedListUseCaseInterface $useCase): ArticlePaginatedListViewModel
    {
        return $useCase->execute($query);
    }
}
