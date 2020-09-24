<?php

declare(strict_types=1);

namespace App\ViewModel;

final class CategoryPageArticle
{
    private int $id;
    private string $title;
    private string $image;
    private string $shortDescription;
    private \DateTimeImmutable $publicationDate;

    public function __construct(
        int $id,
        string $title,
        string $image,
        string $shortDescription,
        \DateTimeImmutable $publicationDate
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
        $this->shortDescription = $shortDescription;
        $this->publicationDate = $publicationDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function getPublicationDate(): \DateTimeImmutable
    {
        return $this->publicationDate;
    }
}
