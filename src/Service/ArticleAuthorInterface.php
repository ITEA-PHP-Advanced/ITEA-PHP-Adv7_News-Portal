<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\CreateArticle;
use App\Entity\Article;

interface ArticleAuthorInterface
{
    /**
     * @return Article[]
     */
    public function getList(): array;

    public function getById(int $id): Article;

    public function create(CreateArticle $dto): Article;

    public function delete(int $id): void;
}
