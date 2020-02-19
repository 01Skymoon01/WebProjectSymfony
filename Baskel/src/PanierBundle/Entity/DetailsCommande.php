<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailsCommande
 *
 * @ORM\Table(name="details_commande")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\DetailsCommandeRepository")
 */
class DetailsCommande
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
     * @var
     * @ORM\ManyToOne(targetEntity="Commande")
     * @ORM\JoinColumn(name="idCommande",referencedColumnName="id")
     */

    private $idCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="nomProduit", type="string", length=255)
     */
    private $nomProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="idProduit", type="integer")
     */
    private $idProduit;

    /**
     * @var int
     *
     * @ORM\Column(name="qteProduit", type="integer")
     */
    private $qteProduit;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixPrduit", type="float")
     */
    private $prixPrduit;


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
     **
     * @param mixed $idCommande
     */


    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    /**
     * @return  mixed
     */

    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Set nomProduit
     *
     * @param string $nomProduit
     *
     * @return DetailsCommande
     */
    public function setNomProduit($nomProduit)
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    /**
     * Get nomProduit
     *
     * @return string
     */
    public function getNomProduit()
    {
        return $this->nomProduit;
    }

    /**
     * Set idProduit
     *
     * @param integer $idProduit
     *
     * @return DetailsCommande
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    /**
     * Get idProduit
     *
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * Set qteProduit
     *
     * @param integer $qteProduit
     *
     * @return DetailsCommande
     */
    public function setQteProduit($qteProduit)
    {
        $this->qteProduit = $qteProduit;

        return $this;
    }

    /**
     * Get qteProduit
     *
     * @return int
     */
    public function getQteProduit()
    {
        return $this->qteProduit;
    }

    /**
     * Set prixPrduit
     *
     * @param float $prixPrduit
     *
     * @return DetailsCommande
     */
    public function setPrixPrduit($prixPrduit)
    {
        $this->prixPrduit = $prixPrduit;

        return $this;
    }

    /**
     * Get prixPrduit
     *
     * @return float
     */
    public function getPrixPrduit()
    {
        return $this->prixPrduit;
    }
}