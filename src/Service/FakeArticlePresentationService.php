<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\EntityNotFoundException;
use App\ViewModel\FullArticle;
use Faker\Factory;
use Faker\Generator;

final class FakeArticlePresentationService implements ArticlePresentationInterface
{
    private const CATEGORIES = [
        'World',
        'Sport',
        'IT',
        'Science',
    ];

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getById(int $id): FullArticle
    {
        $this->ensureThatArticleExists($id);

        return $this->createArticle($id);
    }

    private function ensureThatArticleExists(int $id): void
    {
        if ($this->faker->boolean(20)) {
            throw new EntityNotFoundException('Article', $id);
        }
    }

    private function createArticle(int $id): FullArticle
    {
        return new FullArticle(
            $id,
            $this->faker->randomElement(self::CATEGORIES),
            $this->generateTitle(),
            $this->generateBody(),
            \DateTimeImmutable::createFromMutable($this->faker->dateTimeThisYear)
        );
    }

    private function generateTitle(): string
    {
        $title = $this->faker->words(
            $this->faker->numberBetween(1, 4),
            true
        );

        return \ucfirst($title);
    }

    private function generateBody(): string
    {
        $body = '';
        $paragraphsCount = $this->faker->numberBetween(6, 20);

        for ($i = 0; $i < $paragraphsCount; ++$i) {
            $sentencesCount = $this->faker->numberBetween(1, 5);
            $body .= \sprintf('<p>%s</p>', $this->faker->sentences($sentencesCount, true));
        }

        return $body;
    }
}
