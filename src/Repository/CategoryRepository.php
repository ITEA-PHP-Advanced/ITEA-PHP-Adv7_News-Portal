<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getBySlugWithArticles(string $slug): Category
    {
        $query = $this->createQueryBuilder('c')
            ->andWhere('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->leftJoin('c.articles', 'a')
            ->addSelect('a')
            ->andWhere('a.publicationDate IS NOT NULL')
            ->getQuery()
        ;

        $category = $query->getOneOrNullResult();

        if (null === $category) {
            throw EntityNotFoundException::bySlug('Category', $slug);
        }

        return $category;
    }
}
