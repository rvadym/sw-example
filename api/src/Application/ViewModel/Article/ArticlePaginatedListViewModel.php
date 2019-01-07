<?php declare(strict_types=1);

namespace Api\Application\ViewModel\Article;

use Api\Application\UseCase\ViewModelInterface;
use Api\Application\ViewModel\PaginationViewModel;

class ArticlePaginatedListViewModel implements ViewModelInterface
{
    /** @var ArticleCollection */
    private $articles = [];
    /** @var PaginationViewModel */
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
