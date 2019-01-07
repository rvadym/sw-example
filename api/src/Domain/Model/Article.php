<?php declare(strict_types=1);

namespace Api\Domain\Model;

use Api\Domain\ValueObject\Article\ArticleBody;
use Api\Domain\ValueObject\Article\ArticleTitle;

class Article
{
    /** @var ArticleTitle */
    private $title;
    /** @var ArticleBody */
    private $body;

    /**
     * @return ArticleTitle
     */
    public function getTitle(): ArticleTitle
    {
        return $this->title;
    }

    /**
     * @param ArticleTitle $title
     */
    public function setTitle(ArticleTitle $title): void
    {
        $this->title = $title;
    }

    /**
     * @return ArticleBody
     */
    public function getBody(): ArticleBody
    {
        return $this->body;
    }

    /**
     * @param ArticleBody $body
     */
    public function setBody(ArticleBody $body): void
    {
        $this->body = $body;
    }
}
