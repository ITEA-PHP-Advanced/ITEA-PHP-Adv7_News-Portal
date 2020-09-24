<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ArticleFixtures extends AbstractFixture implements DependentFixtureInterface
{
    private const ARTICLES_COUNT = 15;

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::ARTICLES_COUNT; ++$i) {
            $article = $this->createArticle();

            if ($this->faker->boolean(80)) {
                $article->publish();
            }

            $manager->persist($article);
        }

        $manager->flush();
    }

    private function createArticle(): Article
    {
        $category = $this->getReference($this->faker->randomElement(CategoryFixtures::CATEGORIES));
        $article = new Article($category, $this->generateTitle());

        return $article
            ->addImage($this->faker->imageUrl())
            ->addShortDescription($this->generateShortDescription())
            ->addBody($this->generateBody())
        ;
    }

    private function generateTitle(): string
    {
        $title = $this->faker->words(
            $this->faker->numberBetween(1, 4),
            true
        );

        return \ucfirst($title);
    }

    private function generateShortDescription(): string
    {
        return $this->faker->words(
            $this->faker->numberBetween(3, 7),
            true
        );
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
