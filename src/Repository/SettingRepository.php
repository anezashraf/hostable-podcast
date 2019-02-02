<?php

namespace App\Repository;

use App\Entity\Setting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Setting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Setting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Setting[]    findAll()
 * @method Setting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Setting::class);
    }

    public function findByName(string $name)
    {

        $value = $this->createQueryBuilder('setting')
            ->select('setting.value')
            ->andWhere('setting.name= :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult(4);

        if ($value == 'true' || $value == 'false') {
            return filter_var(    $value, FILTER_VALIDATE_BOOLEAN);
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

    // /**
    //  * @return Setting[] Returns an array of Setting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Setting
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
