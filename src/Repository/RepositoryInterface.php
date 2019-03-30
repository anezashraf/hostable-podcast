<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use App\Entity\Episode;
use App\Entity\Podcast;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Nette\Neon\Entity;
use Symfony\Bridge\Doctrine\RegistryInterface;

interface RepositoryInterface
{
    public function get($id = 1);

    public function getAll();

    public function saveOrUpdate(EntityInterface $entity);
}
