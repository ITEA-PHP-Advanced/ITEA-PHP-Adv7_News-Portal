<?php

declare(strict_types=1);

namespace App\Service;

use App\ViewModel\CategoryWithArticles;

interface CategoryPresentationInterface
{
    /**
     * @throws \App\Exception\EntityNotFoundException
     */
    public function getBySlug(string $slug): CategoryWithArticles;

    /**
     * @return \App\ViewModel\CategoryMenuItem[]
     */
    public function getMenuItems(): iterable;
}
