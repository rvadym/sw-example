<?php declare(strict_types=1);

namespace Api\Adapter\Controller;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\UseCase\UseCaseInterface;
use Api\Application\UseCase\ViewModelInterface;
use Sw\Adapter\View\ControllerInterface;

class ArticleController implements ControllerInterface
{
    /**
     * @param ArticlePaginatedListQuery $query
     * @param UseCaseInterface $useCase
     * @return ViewModelInterface
     */
    public function list(ArticlePaginatedListQuery $query, UseCaseInterface $useCase): ViewModelInterface
    {
        return $useCase->execute($query);
    }
}
