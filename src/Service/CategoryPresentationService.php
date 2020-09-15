<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\ViewModel\CategoryWithArticles;

final class CategoryPresentationService implements CategoryPresentationInterface
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @throws \App\Exception\EntityNotFoundException
     */
    public function getBySlug(string $slug): CategoryWithArticles
    {
        $category = $this->categoryRepository->getBySlugWithArticles($slug);

        return $category->getCategoryWithArticles();
    }

    public function getMenuItems(): iterable
    {
        $categories = $this->categoryRepository->findAll();

        return \array_map(fn (Category $category) => $category->getMenuItem(), $categories);
    }
}
