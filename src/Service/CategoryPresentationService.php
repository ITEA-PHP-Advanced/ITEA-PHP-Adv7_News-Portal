<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Entity\User;
use App\Exception\UserDoesNotHaveSubscriptionException;
use App\Repository\CategoryRepository;
use App\ViewModel\CategoryWithArticles;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class CategoryPresentationService implements CategoryPresentationInterface
{
    private CategoryRepository $categoryRepository;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(CategoryRepository $categoryRepository, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->categoryRepository = $categoryRepository;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @throws \App\Exception\EntityNotFoundException
     */
    public function getBySlug(string $slug): CategoryWithArticles
    {
        $category = $this->categoryRepository->getBySlugWithArticles($slug);

        if ($this->authorizationChecker->isGranted(User::ROLE_SUBSCRIBER)) {
            return $category->getCategoryWithArticles();
        }

        if ($category->isSubscriptionNeeded()) {
            throw new UserDoesNotHaveSubscriptionException();
        }

        return $category->getCategoryWithArticles();
    }

    public function getMenuItems(): iterable
    {
        $categories = $this->categoryRepository->findAll();

        if ($this->authorizationChecker->isGranted(User::ROLE_SUBSCRIBER)) {
            return \array_map(fn (Category $category) => $category->getMenuItem(), $categories);
        }

        $freeCategories = \array_filter($categories, fn (Category $category) => !$category->isSubscriptionNeeded());

        return \array_map(fn (Category $category) => $category->getMenuItem(), $freeCategories);
    }
}
