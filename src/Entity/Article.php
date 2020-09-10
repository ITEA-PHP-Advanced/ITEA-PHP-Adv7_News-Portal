<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\ArticleBodyCannotBeEmptyException;
use App\Exception\ArticleImageCannotBeEmptyException;
use App\Exception\ArticleShortDescriptionCannotBeEmptyException;
use App\Repository\ArticleRepository;
use App\Util\SlugUtil;
use App\ViewModel\FullArticle;
use App\ViewModel\HomePageArticle;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
    private string $title;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private ?string $slug = null;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private ?string $image = null;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private ?string $shortDescription = null;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $body = null;
    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $publicationDate = null;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $createdAt;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTimeImmutable $updatedAt;

    public function __construct(string $title)
    {
        Assert::notEmpty($title);

        $this->title = $title;
        $this->createdAt = $this->updatedAt = new \DateTimeImmutable();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getPublicationDate(): ?\DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function getHomePageArticle(): HomePageArticle
    {
        return new HomePageArticle(
            $this->id,
            'Set category title here', // TODO: set category title
            $this->title,
            $this->publicationDate,
            $this->image,
            $this->shortDescription
        );
    }

    public function getFullArticle(): FullArticle
    {
        return new FullArticle(
            $this->id,
            'Set category title here', // TODO: set category title
            $this->title,
            $this->body,
            $this->publicationDate
        );
    }

    public function addImage(?string $image): self
    {
        $this->image = $image;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function addShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    public function addBody(?string $body): self
    {
        $this->body = $body;
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @throws ArticleImageCannotBeEmptyException
     * @throws ArticleShortDescriptionCannotBeEmptyException
     * @throws ArticleBodyCannotBeEmptyException
     */
    public function publish(): void
    {
        if (null === $this->image) {
            throw new ArticleImageCannotBeEmptyException();
        }

        if (null === $this->shortDescription) {
            throw new ArticleShortDescriptionCannotBeEmptyException();
        }

        if (null === $this->body) {
            throw new ArticleBodyCannotBeEmptyException();
        }

        $this->createSlug();

        $this->publicationDate = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    private function createSlug(): void
    {
        $this->slug = SlugUtil::generate($this->title);
    }
}
