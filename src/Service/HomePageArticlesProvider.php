<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\HomePageArticles;
use App\Entity\Article;
use App\Repository\ArticleRepository;

final class HomePageArticlesProvider implements HomePageArticlesProviderInterface
{
    private ArticleRepository $articleRepository;
    private int $showLimit;

    public function __construct(ArticleRepository $articleRepository, int $showLimit)
    {
        $this->articleRepository = $articleRepository;
        $this->showLimit = $showLimit;
    }

    public function getList(): HomePageArticles
    {
        $articles = $this->articleRepository->getLatestPublished($this->showLimit);
        $viewModels = \array_map(fn (Article $article) => $article->getHomePageArticle(), $articles);

        return new HomePageArticles(...$viewModels);
    }
}
