<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

final class CategoryFixtures extends AbstractFixture
{
    public const CATEGORIES = [
        'World',
        'Sport',
        'IT',
        'Science',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::CATEGORIES as $categoryName) {
            $category = new Category($categoryName);
            $manager->persist($category);

            $this->addReference($categoryName, $category);
        }

        $manager->flush();
    }
}
