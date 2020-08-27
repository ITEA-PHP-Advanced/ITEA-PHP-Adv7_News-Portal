<?php

declare(strict_types=1);

namespace App\Service;

use App\Collection\HomePageArticles;

interface HomePageArticlesProviderInterface
{
    public function getList(): HomePageArticles;
}
