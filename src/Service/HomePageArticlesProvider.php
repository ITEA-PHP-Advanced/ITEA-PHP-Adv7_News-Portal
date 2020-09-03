<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\HomePageArticles;
use App\Entity\Article;
use App\Repository\ArticleRepository;

final class HomePageArticlesProvider implements HomePageArticlesProviderInterface
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getList(): HomePageArticles
    {
        $articles = $this->articleRepository->getLatestPublished();
        $viewModels = \array_map(fn (Article $article) => $article->getHomePageArticle(), $articles);

        return new HomePageArticles(...$viewModels);
    }
}
