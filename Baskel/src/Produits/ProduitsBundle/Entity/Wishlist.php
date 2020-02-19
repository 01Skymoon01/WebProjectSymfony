<?php

namespace Produits\ProduitsBundle\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist")
 * @ORM\Entity(repositoryClass="Produits\ProduitsBundle\Repository\WishlistRepository")
 * @ORM\Entity
 * @UniqueEntity("nom_prod")
 */

class Wishlist
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
     * @ORM\ManyToOne(targetEntity="Produits",  inversedBy="wishlist",cascade={"remove"})
     * @ORM\JoinColumn(name="refP",referencedColumnName="ref_p",nullable=false)
     */
    private $refP;



    /**
     * @var string
     *
     * @ORM\Column(name="nom_prod", type="string", length=255, unique=true)
     */
    private $nomProd;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_prod", type="float")
     */
    private $prixProd;

    /**
     * @var int
     *
     * @ORM\Column(name="qte_prod", type="integer")
     */
    private $qteProd;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="id_client",referencedColumnName="id",nullable=false)
     */
    private $idClient;






    /**
     * @var string
     *
     * @ORM\Column(name="image_prod", type="string", length=255)
     */
    private $imageProd;














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
     * Set nomProd
     *
     * @param string $nomProd
     *
     * @return Wishlist
     */
    public function setNomProd($nomProd)
    {
        $this->nomProd = $nomProd;

        return $this;
    }

    /**
     * Get nomProd
     *
     * @return string
     */
    public function getNomProd()
    {
        return $this->nomProd;
    }

    /**
     * Set prixProd
     *
     * @param float $prixProd
     *
     * @return Wishlist
     */
    public function setPrixProd($prixProd)
    {
        $this->prixProd = $prixProd;

        return $this;
    }

    /**
     * Get prixProd
     *
     * @return float
     */
    public function getPrixProd()
    {
        return $this->prixProd;
    }

    /**
     * Set qteProd
     *
     * @param integer $qteProd
     *
     * @return Wishlist
     */
    public function setQteProd($qteProd)
    {
        $this->qteProd = $qteProd;

        return $this;
    }

    /**
     * Get qteProd
     *
     * @return int
     */
    public function getQteProd()
    {
        return $this->qteProd;
    }

    /**
     * Set idClient
     *
     * @param integer $idClient
     *
     * @return Wishlist
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
     * @param mixed $refP
     */
    public function setRefP($refP)
    {
        $this -> refP = $refP;
    }

    /**
     * @return mixed
     */
    public function getRefP()
    {
        return $this -> refP;
    }

    /**
     * @return string
     */
    public function getImageProd()
    {
        return $this -> imageProd;
    }

    /**
     * @param string $imageProd
     */
    public function setImageProd($imageProd)
    {
        $this -> imageProd = $imageProd;
    }



}

