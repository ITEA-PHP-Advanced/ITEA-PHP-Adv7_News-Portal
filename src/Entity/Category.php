<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use App\Util\SlugUtil;
use App\ViewModel\CategoryMenuItem;
use App\ViewModel\CategoryWithArticles;
use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;
    /**
     * @ORM\Column(type="string", length=500, unique=true)
     */
    private string $slug;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;
    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="category")
     */
    private Collection $articles;

    public function __construct(string $name)
    {
        Assertion::notEmpty($name);

        $this->name = $name;
        $this->slug = SlugUtil::generate($name);
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
        $this->articles = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCategoryWithArticles(): CategoryWithArticles
    {
        $articles = $this->articles->map(fn (Article $article) => $article->getCategoryPageArticle())->toArray();

        return new CategoryWithArticles(
            $this->name,
            ...$articles
        );
    }

    public function getMenuItem(): CategoryMenuItem
    {
        return new CategoryMenuItem($this->name, $this->slug);
    }

    public function isSubscriptionNeeded(): bool
    {
        // TODO: add flag to database
        return \in_array($this->name, ['IT']);
    }
}
