<?php

namespace App\Repository\Contracts;

use App\Entity\Contracts\EntityInterface;

interface RepositoryInterface
{
    public function get($id = 1);

    public function getAll();

    public function saveOrUpdate(EntityInterface $entity);
}
