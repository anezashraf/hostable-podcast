<?php

namespace App\Repository;

use App\Entity\Contracts\EntityInterface;
use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Repository\Contracts\RepositoryInterface;

class SettingRepository extends ServiceEntityRepository implements RepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws NoResultException
     */
    public function findByName(string $name)
    {

        $value = $this->createQueryBuilder('setting')
            ->select('setting.value')
            ->andWhere('setting.name= :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult(4);

        if ($value == 'true' || $value == 'false') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        return $value;
    }

    public function update(array $array)
    {
        $query = $this->createQueryBuilder('setting')
            ->update()
            ->set('setting.value', ':value')
            ->where('setting.name = :name')
            ->setParameter('name', $array['name'])
            ->setParameter('value', $array['value'])
            ->getQuery();

        $query->execute();
    }

    public function insert(Setting $setting)
    {
        $this->_em->merge($setting);
        $this->_em->flush();
    }

    public function getAll()
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.editableFromDashboard = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult();
    }

    public function get($id = 1) : Setting
    {
        return $this->createQueryBuilder('e')
            ->where('e.name = :name')
            ->setParameter('name', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function saveOrUpdate(EntityInterface $setting)
    {
        $this->_em->merge($setting);
        $this->_em->flush($setting);
    }
}
