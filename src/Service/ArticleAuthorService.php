<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateArticle;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

final class ArticleAuthorService implements ArticleAuthorInterface
{
    private ArticleRepository $articleRepository;
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $em;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $em
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    public function getList(): array
    {
        return $this->articleRepository->findAll();
    }

    public function getById(int $id): Article
    {
        return $this->articleRepository->getById($id);
    }

    public function create(CreateArticle $dto): Article
    {
        $category = $this->categoryRepository->getById($dto->getCategoryId());
        $article = new Article($category, $dto->getTitle());

        $this->em->persist($article);
        $this->em->flush();

        return $article;
    }

    public function delete(int $id): void
    {
        $article = $this->articleRepository->getById($id);

        $this->em->remove($article);
        $this->em->flush();
    }
}
