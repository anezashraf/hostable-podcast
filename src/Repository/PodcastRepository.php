<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Podcast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use UnexpectedValueException;

/**
 * @method Podcast|null find($id, $lockMode = null, $lockVersion = null)
 * @method Podcast|null findOneBy(array $criteria, array $orderBy = null)
 * @method Podcast[]    findAll()
 * @method Podcast[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PodcastRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Podcast::class);
    }

    public function update(Podcast $podcast)
    {
        $dbPodcast = $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult();

        if (! empty($dbPodcast)) {
            throw new UnexpectedValueException('Podcast already exists, something it horribly wrong');
        }

        $this->_em->persist($podcast);
        $this->_em->flush($podcast);
    }

    public function saveOrUpdate(EntityInterface $podcast)
    {
        $this->_em->merge($podcast);
        $this->_em->flush($podcast);
    }

    public function getWithEpisodes(?int $limit = null)
    {
        $query = $this->createQueryBuilder('p')
            ->select('p', 'e')
            ->join('p.episodes', 'e')
            ->andWhere('p.id = :id')
            ->orderBy('e.publishedAt', 'DESC')
            ->setParameter('id', 1);

        if (! is_null($limit)) {
            $query->setMaxResults($limit);
        }

        return $query->getQuery()->getSingleResult();
    }

    public function get($id = 1) : Podcast
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getWithEpisode(string $slug)
    {
        return $this->createQueryBuilder('p')
            ->select('p', 'e')
            ->join('p.episodes', 'e')
            ->andWhere('p.id = :id')
            ->andWhere('e.slug = :slug')
            ->orderBy('e.publishedAt', 'DESC')
            ->setParameter('id', 1)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleResult();
    }


    // /**
    //  * @return Podcast[] Returns an array of Podcast objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Podcast
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getAll()
    {
        return $this->findAll();
    }
}
