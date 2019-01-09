<?php declare(strict_types=1);

namespace Api\Adapter\Controller;

use Api\Application\Query\Article\ArticlePaginatedListQuery;
use Api\Application\ViewModel\Article\ArticlePaginatedListViewModel;
use Api\Application\ViewTransformer\Article\ArticlePaginatedListViewTransformerInterface;
use Sw\Adapter\View\ControllerInterface;
use Sw\Util\Annotation\SwEndpointAnnotation as SwEndpoint;

class ArticleController implements ControllerInterface
{
    /**
     * @param ArticlePaginatedListQuery $query
     * @param ArticlePaginatedListViewTransformerInterface $viewTransformer
     * @return ArticlePaginatedListViewModel
     *
     * @SwEndpoint(
     *     path="/articles",
     *     method="GET",
     *     summary="List of articles",
     *     operationId="listArticles",
     *     tag="articles",
     * )
     */
    public function list(
        ArticlePaginatedListQuery $query,
        ArticlePaginatedListViewTransformerInterface $viewTransformer
    ) : ArticlePaginatedListViewModel {
        return $viewTransformer->execute($query);
    }
}
