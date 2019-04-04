<?php

namespace App\Repository;

use App\Entity\Contracts\EntityInterface;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use UnexpectedValueException;
use App\Repository\Contracts\RepositoryInterface;

class UserRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function saveOrUpdate(EntityInterface $user)
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }

    public function insert(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush($user);
    }

    public function get($id = 0)
    {
        return $this->find($id);
    }

    public function getAll()
    {
        return $this->findAll();
    }
}
