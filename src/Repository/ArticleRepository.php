<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function add(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Function to search latest posts with limit
     *
     * @param integer $limit number of max results in query
     * @return array
     */
    public function findLatestArticleWithLimit(int $limit): array
    {
        return $this->createQueryBuilder('a')
            ->select('a', 'u', 'i')
            ->join('a.user', 'u')
            ->leftJoin('a.images', 'i')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Method custom for search posts with categorie and author
     *
     * @return array
     */
    public function findSearchData(SearchData $search): array
    {
        $query = $this->createQueryBuilder('a')
            ->select('a', 'u', 'c', 'co', 'i')
            ->join('a.user', 'u')
            ->leftJoin('a.categories', 'c')
            ->leftJoin('a.comments', 'co')
            ->leftJoin('a.images', 'i');

        if (!empty($search->getQuery())) {
            $query = $query->andWhere('a.titre LIKE :titre')
                /**
                 * "%%" partial search SQL
                 */
                ->setParameter('titre', "%{$search->getQuery()}%");
        }

        if (!empty($search->getCategories())) {
            $query = $query->andWhere('c.id IN(:tags)')
                ->setParameter('tags', $search->getCategories());
        }

        if (!empty($search->getAuthor())) {
            $query = $query->andWhere('u.id IN(:users)')
                ->setParameter('users', $search->getAuthor());
        }

        return $query->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}