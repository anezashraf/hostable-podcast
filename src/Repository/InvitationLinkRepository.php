<?php

namespace App\Repository;

use App\Entity\InvitationLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method InvitationLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method InvitationLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method InvitationLink[]    findAll()
 * @method InvitationLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvitationLinkRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InvitationLink::class);
    }

    public function addInvitationLink(string $link)
    {
        $invitationLink = new InvitationLink($link);

        $this->_em->persist($invitationLink);
        $this->_em->flush();
    }

    public function get(string $invitationLink)
    {
        return $this->createQueryBuilder('i')
            ->where('i.link = :link')
            ->andWhere('i.used is null')
            ->setParameter('link', $invitationLink)
            ->getQuery()
            ->getSingleResult();
    }

    public function insert(InvitationLink $invitationLink)
    {
        $this->_em->merge($invitationLink);
        $this->_em->flush();
    }

    // /**
    //  * @return InvitationLink[] Returns an array of InvitationLink objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InvitationLink
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
