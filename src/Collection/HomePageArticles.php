<?php

declare(strict_types=1);

namespace App\Collection;

use App\ViewModel\HomePageArticle;

final class HomePageArticles implements \IteratorAggregate
{
    private array $articles;

    public function __construct(HomePageArticle ...$articles)
    {
        $this->articles = $articles;
    }

    public function getLates(int $count): self
    {
        $lates = [];

        for ($i = 0; $i < $count; ++$i) {
            $article = \array_shift($this->articles);

            if (null === $article) {
                break;
            }

            $lates[] = $article;
        }

        return new self(...$lates);
    }

    public function getOneLates(): ?HomePageArticle
    {
        return \array_shift($this->articles);
    }

    public function getIterator(): iterable
    {
        return new \ArrayIterator($this->articles);
    }
}
