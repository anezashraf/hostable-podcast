<?php

namespace App\Repository;

use App\Entity\InvitationLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

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
}
