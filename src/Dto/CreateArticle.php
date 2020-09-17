<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateArticle
{
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private ?string $title;
    /**
     * @Assert\NotBlank()
     */
    private ?int $categoryId;

    public static function fromRequest(array $request): self
    {
        $self = new self();

        $self->title = $request['title'] ?? null;
        $self->categoryId = isset($request['category_id']) ? (int) $request['category_id'] : null;

        return $self;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
}
