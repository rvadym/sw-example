<?php declare(strict_types=1);

namespace Api\Application\ViewModel\Article;

use Api\Application\ViewModel\Collection;
use Api\Domain\Model\Article;

class ArticleCollection extends Collection
{
    /** {@inheritdoc} */
    protected function validate($item): void
    {
        if (!$item instanceof Article) {
            throw new \Exception('Collection item type validation failed.');
        }
    }
}
