<?php

declare(strict_types=1);

namespace App\ViewModel;

final class CategoryWithArticles
{
    private string $name;
    /** @var CategoryPageArticle[] */
    private array $articles;

    public function __construct(string $name, CategoryPageArticle ...$articles)
    {
        $this->name = $name;
        $this->articles = $articles;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return CategoryPageArticle[]
     */
    public function getArticles(): array
    {
        return $this->articles;
    }
}
