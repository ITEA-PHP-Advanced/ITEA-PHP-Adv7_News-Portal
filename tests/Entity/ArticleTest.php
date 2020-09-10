<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Article;
use App\Exception\ArticleBodyCannotBeEmptyException;
use App\Exception\ArticleImageCannotBeEmptyException;
use App\Exception\ArticleShortDescriptionCannotBeEmptyException;
use PHPUnit\Framework\TestCase;

final class ArticleTest extends TestCase
{
    public function testCreate(): void
    {
        $title = 'This is test.';
        $article = new Article($title);

        static::assertEquals($title, $article->getTitle(), 'Title must be set.');
        static::assertSame(
            $article->getCreatedAt(),
            $article->getUpdatedAt(),
            'Created at and updated at dates must be equal after creating.'
        );
    }

    public function testCreateArticleWithEmptyTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Article('');
    }

    public function testPublish(): void
    {
        $article = new Article('This is test.');
        $article
            ->addImage('/img/test.png')
            ->addShortDescription('This is test short description.')
            ->addBody('This is test body.')
        ;

        $article->publish();

        static::assertEquals('this-is-test', $article->getSlug());
        static::assertInstanceOf(\DateTimeImmutable::class, $article->getPublicationDate());
        static::assertInstanceOf(\DateTimeImmutable::class, $article->getUpdatedAt());
    }

    public function testPublishWithoutImage(): void
    {
        $this->expectException(ArticleImageCannotBeEmptyException::class);

        $article = new Article('This is test.');
        $article
            ->addShortDescription('This is test short description.')
            ->addBody('This is test body.')
        ;

        $article->publish();
    }

    public function testPublishWithoutShortDescription(): void
    {
        $this->expectException(ArticleShortDescriptionCannotBeEmptyException::class);

        $article = new Article('This is test.');
        $article
            ->addImage('/img/test.png')
            ->addBody('This is test body.')
        ;

        $article->publish();
    }

    public function testPublishWithoutBody(): void
    {
        $this->expectException(ArticleBodyCannotBeEmptyException::class);

        $article = new Article('This is test.');
        $article
            ->addImage('/img/test.png')
            ->addShortDescription('This is test short description.')
        ;

        $article->publish();
    }
}
