<?php

declare(strict_types=1);

namespace App\Exception;

class EntityNotFoundException extends \RuntimeException
{
    public static function byId(string $entityName, int $id): self
    {
        $message = \sprintf('Entity "%s" with ID %d not found.', $entityName, $id);

        return new self($message);
    }

    public static function bySlug(string $entityName, string $slug): self
    {
        $message = \sprintf('Entity "%s" with slug "%s" not found.', $entityName, $slug);

        return new self($message);
    }
}
