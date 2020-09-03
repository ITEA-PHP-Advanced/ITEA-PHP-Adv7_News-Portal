<?php

declare(strict_types=1);

namespace App\Service;

use App\ViewModel\FullArticle;

interface ArticlePresentationInterface
{
    /**
     * @throws \App\Exception\EntityNotFoundException
     */
    public function getById(int $id): FullArticle;
}
