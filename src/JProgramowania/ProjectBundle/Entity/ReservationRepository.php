<?php

namespace JProgramowania\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ReservationRepository extends EntityRepository
{
    public function findActiveReservationsQuantity($datetime)
    {
        $datetime = $datetime->format('Y-m-d H:i:s');
        $entity_manager = $this->getEntityManager();
        $query = $entity_manager->createQuery('SELECT c.id, COUNT(r.id) as quantity FROM JProgramowaniaProjectBundle:Reservation r JOIN r.car c WHERE r.end_date > :end_date AND r.is_active = 1 GROUP BY c.id')->setParameter('end_date', $datetime);
        return $query->getResult();
    }
}
