<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_client", type="integer")
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="TotalPrix", type="float")
     */
    private $totalPrix;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrProduit", type="integer")
     */
    private $nbrProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="etat_liv", type="integer",nullable=true )
     */
    private $etatLiv = 0;

    /**
     * @return int
     */
    public function getEtatLiv()
    {
        return $this->etatLiv;
    }

    /**
     * @param int $etatLiv
     */
    public function setEtatLiv($etatLiv)
    {
        $this->etatLiv = $etatLiv;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idClient
     *
     * @param integer $idClient
     *
     * @return Commande
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set date
     *
     * @param \Date $date
     *
     * @return Commande
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalPrix
     *
     * @param float $totalPrix
     *
     * @return Commande
     */
    public function setTotalPrix($totalPrix)
    {
        $this->totalPrix = $totalPrix;

        return $this;
    }

    /**
     * Get totalPrix
     *
     * @return float
     */
    public function getTotalPrix()
    {
        return $this->totalPrix;
    }

    /**
     * Set nbrProduit
     *
     * @param integer $nbrProduit
     *
     * @return Commande
     */
    public function setNbrProduit($nbrProduit)
    {
        $this->nbrProduit = $nbrProduit;

        return $this;
    }

    /**
     * Get nbrProduit
     *
     * @return int
     */
    public function getNbrProduit()
    {
        return $this->nbrProduit;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }
}