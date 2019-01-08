<?php declare(strict_types=1);

namespace Api\Adapter\Controller;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;
use Api\Application\ViewTransformer\Article\ArticlePaginatedListViewTransformerInterface;
use Sw\Adapter\View\ControllerInterface;

class ArticleController implements ControllerInterface
{
    /**
     * @param ArticlePaginatedListQuery $query
     * @param ArticlePaginatedListViewTransformerInterface $viewTransformer
     * @return ArticlePaginatedListViewModel
     */
    public function list(
        ArticlePaginatedListQuery $query,
        ArticlePaginatedListViewTransformerInterface $viewTransformer
    ) : ArticlePaginatedListViewModel {
        return $viewTransformer->execute($query);
    }
}
