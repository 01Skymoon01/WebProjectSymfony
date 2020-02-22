<?php

namespace Produits\ProduitsBundle\Repository;

/**
 * ProduitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProduitsRepository extends \Doctrine\ORM\EntityRepository
{
    public function FindAllProducts()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM ProduitsBundle:Produits p'
        )->setMaxResults(6);

        return $query->getResult();
    }

    public function FilterPrix($prix)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM ProduitsBundle:Produits p where p.prixP >= :prix'
        )->setParameter('prix',$prix);

        return $query->getResult();
    }

    public function FilterCouleur($id)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM ProduitsBundle:Produits p where p.ref_p like :id'
        )->setParameter('id',$id);

        return $query->getArrayResult();
    }

    public function FilterSexe($sexe)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM ProduitsBundle:Produits p where p.genreP = :sexe'
        )->setParameter('sexe',$sexe);

        return $query->getResult();
    }


    public function UpdateProducts($refP)
    {
        $query = $this->getEntityManager()->createQuery(

            'UPDATE Produits\Produits:Produits p SET p.image = :image or p.nomP = :nomP WHERE p.refP= :refP'
        )->setParameter('refP',$refP);

        return $query->getResult();
    }


    public function getAllQte()
    {
        $query = $this->getEntityManager()->createQuery(

            'SELECT quantiteP from Produits\Produits:Produits'
        );

        return $query->getResult();
    }

    public function TrierProduits()
    {
        $query = $this->getEntityManager()->createQuery(

            'SELECT p from Produits\Produits:Produits ORDER BY p.prixP'
        );

        return $query->getResult();
    }
}
