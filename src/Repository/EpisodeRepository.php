<?php

namespace App\Repository;

use App\Entity\Contracts\EntityInterface;
use App\Entity\Episode;
use App\Repository\Contracts\RepositoryInterface;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EpisodeRepository extends ServiceEntityRepository implements RepositoryInterface
{
    private $podcastRepository;

    public function __construct(RegistryInterface $registry, PodcastRepository $podcastRepository)
    {
        parent::__construct($registry, Episode::class);

        $this->podcastRepository = $podcastRepository;
    }

    /**
     * @param Episode $episode
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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

    public function getAll()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
