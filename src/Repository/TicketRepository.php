<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function save(Ticket $ticket, bool $flush = false): void
    {
        $this->_em->persist($ticket);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Ticket $ticket, bool $flush = false): void
    {
        $this->_em->remove($ticket);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
