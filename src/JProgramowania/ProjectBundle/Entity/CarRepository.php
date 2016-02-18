<?php

namespace JProgramowania\ProjectBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CarRepository extends EntityRepository
{
    public function findIdsAndQuantitys()
    {
        $entity_manager = $this->getEntityManager();
        $query = $entity_manager->createQuery('SELECT c.id, c.quantity FROM JProgramowaniaProjectBundle:Car c');
        return $query->getResult();
    }
}
