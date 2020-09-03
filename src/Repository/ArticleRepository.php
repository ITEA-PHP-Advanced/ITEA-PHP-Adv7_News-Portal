<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArticleRepository extends ServiceEntityRepository
{
    private const LATEST_PUBLISHED_ARTICLES_COUNT = 10;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function getLatestPublished(): array
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.publicationDate IS NOT NULL')
            ->setMaxResults(self::LATEST_PUBLISHED_ARTICLES_COUNT)
            ->orderBy('a.publicationDate', 'DESC')
            ->getQuery()
        ;

        return $query->getResult();
    }
}
