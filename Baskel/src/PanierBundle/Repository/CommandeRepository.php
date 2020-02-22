<?php

namespace PanierBundle\Repository;

/**
 * CommandeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeRepository extends \Doctrine\ORM\EntityRepository
{

    public function ModifierEtat($id,$etat){

        $query = $this->getEntityManager()
            ->createQuery(" UPDATE PanierBundle:Commande c 
SET c.etat = 1
 where c.id =:id ")
            ->setParameter('id', $id)
        ;
        return $query->getResult();
    }

    public  function Supprimer($id){

        $query = $this->getEntityManager()
            ->createQuery(" DELETE FROM PanierBundle:DetailsCommande c 
          where c.idCommande =:id ")
            ->setParameter('id', $id)
        ;
        return $query->getResult();
    }

    public function SelectCommandePaye(){
        $query = $this->getEntityManager()
            ->createQuery(" SELECT c
          FROM PanierBundle:Commande c 
          where c.etat=1");


        return $query->getResult();
    }

    public function SelectCommandeNoPaye(){
        $query = $this->getEntityManager()
            ->createQuery(" SELECT c
          FROM PanierBundle:Commande c 
          where c.etat=0");


        return $query->getResult();
    }

    public function DecrStock($id,$nbr){
        $query = $this->getEntityManager()
            ->createQuery(" UPDATE PanierBundle:produits e 
SET e.quantiteP= e.quantiteP - :nbajouter
 where e.refP=:id ")
            ->setParameter('id', $id)
            ->setParameter('nbajouter', $nbr);
        return $query->getResult();
    }


    public function trieParColumn($Column){
        $query = $this->getEntityManager()
            ->createQuery(" SELECT c
          FROM PanierBundle:Commande c 
          ORDER BY :Column ASC")
        ->setParameter('Column',$Column);


        return $query->getResult();
    }


}