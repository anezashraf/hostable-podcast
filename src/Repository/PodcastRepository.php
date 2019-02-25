<?php

namespace App\Repository;

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
class PodcastRepository extends ServiceEntityRepository
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

    public function saveOrUpdate(Podcast $podcast)
    {
        $this->_em->merge($podcast);
        $this->_em->flush($podcast);
    }

    public function getWithEpisodes()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', 1)
            ->getQuery()
            ->getSingleResult();
    }

    public function get() : Podcast
    {
        return $this->createQueryBuilder('p')
            ->where('p.id = :id')
            ->setParameter('id', 1)
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
}
