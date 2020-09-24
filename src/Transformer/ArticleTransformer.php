<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Entity\Article;
use League\Fractal\TransformerAbstract;

final class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article): array
    {
        return [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'short_description' => $article->getShortDescription(),
            'image' => $article->getImage(),
            'body' => $article->getBody(),
            'publication_date' => $article->getPublicationDate()
                ? $article->getPublicationDate()->format(\DateTimeInterface::RFC3339)
                : null,
            'created_at' => $article->getCreatedAt()->format(\DateTimeInterface::RFC3339),
            'updated_at' => $article->getUpdatedAt()->format(\DateTimeInterface::RFC3339),
        ];
    }
}
