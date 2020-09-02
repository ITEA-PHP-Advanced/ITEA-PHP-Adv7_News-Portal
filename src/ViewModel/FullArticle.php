<?php

declare(strict_types=1);

namespace App\ViewModel;

final class FullArticle
{
    private int $id;
    private string $categoryTitle;
    private string $title;
    private string $body;
    private \DateTimeImmutable $publicationDate;

    public function __construct(
        int $id,
        string $categoryTitle,
        string $title,
        string $body,
        \DateTimeImmutable $publicationDate
    ) {
        $this->id = $id;
        $this->categoryTitle = $categoryTitle;
        $this->title = $title;
        $this->body = $body;
        $this->publicationDate = $publicationDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryTitle(): string
    {
        return $this->categoryTitle;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getPublicationDate(): \DateTimeImmutable
    {
        return $this->publicationDate;
    }
}
