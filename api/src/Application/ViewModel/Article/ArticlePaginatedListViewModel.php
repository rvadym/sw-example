<?php declare(strict_types=1);

namespace Api\Application\ViewModel\Article;

use Api\Application\ViewModel\PaginationViewModel;
use Sw\Application\ViewModelInterface;
use Sw\Util\Annotation\SwViewModelPropertyAnnotation as SwViewModelProperty;
use Sw\Util\Annotation\SwViewModelAnnotation as SwViewModel;

/**
 * Class ArticlePaginatedListViewModel
 * @package Api\Application\ViewModel\Article
 *
 * @SwViewModel(
 *     code=200,
 *     description="ArticlePaginatedListViewModel description",
 * )
 */
class ArticlePaginatedListViewModel implements ViewModelInterface
{
    /**
     * @var ArticleCollection
     *
     * @SwViewModelProperty(
     *     required=true,
     *     type="Api\Application\ViewModel\Article\ArticleCollection",
     * )
     */
    private $articles = [];

    /**
     * @var PaginationViewModel
     *
     * @SwViewModelProperty(
     *     required=true,
     *     type="Api\Application\ViewModel\PaginationViewModel",
     * )
     */
    private $pagination;

    /**
     * ArticlePaginatedListViewModel constructor.
     * @param ArticleCollection $articles
     * @param int $total
     * @param int $current
     */
    public function __construct(ArticleCollection $articles, int $total, int $current)
    {
        $this->articles = $articles;
        $this->pagination = new PaginationViewModel($total, $current);
    }

    /**
     * @return ArticleCollection
     */
    public function getArticles(): ArticleCollection
    {
        return $this->articles;
    }

    /**
     * @return PaginationViewModel
     */
    public function getPagination(): PaginationViewModel
    {
        return $this->pagination;
    }
}
