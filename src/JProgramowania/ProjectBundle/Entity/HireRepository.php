<?php

namespace JProgramowania\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;

class HireRepository extends EntityRepository
{
    public function findActiveHiresQuantity($datetime)
    {
        $datetime = $datetime->format('Y-m-d H:i:s');
        $entity_manager = $this->getEntityManager();
        $query = $entity_manager->createQuery('SELECT c.id, COUNT(h.id) as quantity FROM JProgramowaniaProjectBundle:Hire h JOIN h.car c WHERE h.end_date > :end_date GROUP BY c.id')->setParameter('end_date', $datetime);
        return $query->getResult();
    }
}
