<?php

namespace App\Repository;

use App\Entity\Episode;
use App\Entity\Podcast;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Episode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Episode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Episode[]    findAll()
 * @method Episode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Episode::class);
    }

    public function saveOrUpdate(Episode $episode)
    {
        if (is_null($episode->getPodcast())) {
            $podcast = $this->_em->getRepository(Podcast::class)->find(1);
            $episode->setPodcast($podcast);
            $episode->setPublishedAt(new DateTime());
        }
        $this->_em->persist($episode);
        $this->_em->flush($episode);
    }

    public function findAllOrdered()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();

    }

    public function get(string $id) : Episode
    {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    // /**
    //  * @return Episode[] Returns an array of Episode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Episode
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
