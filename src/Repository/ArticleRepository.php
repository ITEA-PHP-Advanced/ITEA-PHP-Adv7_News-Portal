<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends ServiceEntityRepository
{
    private const DEFAULT_LATEST_PUBLISHED_ARTICLES_LIMIT = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Article
    {
        $query = $this->addPublished()
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        $article = $query->getOneOrNullResult();

        if (null === $article) {
            throw new EntityNotFoundException('Article', $id);
        }

        return $article;
    }

    /**
     * @return Article[]
     */
    public function getLatestPublished(int $limit = self::DEFAULT_LATEST_PUBLISHED_ARTICLES_LIMIT): array
    {
        $query = $this->addPublished()
            ->setMaxResults($limit)
            ->orderBy('a.publicationDate', 'DESC')
            ->getQuery()
        ;

        return $query->getResult();
    }

    private function addPublished(?QueryBuilder $qb = null): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder($qb)
            ->andWhere('a.publicationDate IS NOT NULL')
        ;
    }

    private function getOrCreateQueryBuilder(?QueryBuilder $qb = null): QueryBuilder
    {
        return $qb ?? $this->createQueryBuilder('a');
    }
}
