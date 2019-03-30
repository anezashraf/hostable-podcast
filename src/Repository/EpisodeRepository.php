<?php

namespace App\Repository;

use App\Entity\EntityInterface;
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
class EpisodeRepository extends ServiceEntityRepository implements RepositoryInterface
{
    private $podcastRepository;

    public function __construct(RegistryInterface $registry, PodcastRepository $podcastRepository)
    {
        parent::__construct($registry, Episode::class);

        $this->podcastRepository = $podcastRepository;
    }

    public function saveOrUpdate(EntityInterface $episode)
    {
        if (is_null($episode->getPodcast())) {
            $podcast = $this->podcastRepository->get();
            $episode->setPodcast($podcast);
            $episode->setPublishedAt(new DateTime());
        }
        $this->_em->persist($episode);
        $this->_em->flush($episode);
    }

    public function findAllOrdered()
    {

    }

    public function get($id = 1) : Episode
    {
        return $this->createQueryBuilder('e')
            ->where('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getBySlug(string $slug)
    {
        return $this->createQueryBuilder('e')
            ->where('e.slug = :slug')
            ->setParameter('slug', $slug)
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
    public function getAll()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
