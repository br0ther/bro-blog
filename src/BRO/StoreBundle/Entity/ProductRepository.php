<?php

namespace BRO\StoreBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 */
class ProductRepository extends EntityRepository {

    public function findOneByIdJoinedToCategory($id) {
        $query = $this->getEntityManager()
                        ->createQuery(
                                'SELECT p, c FROM BROStoreBundle:Product p
            JOIN p.category c
            WHERE p.id = :id'
                        )->setParameter('id', $id);
        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

}
