<?php

namespace PanierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity(repositoryClass="PanierBundle\Repository\produitsRepository")
 */
class produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_p", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $refP;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_p", type="string", length=255)
     */
    private $nomP;

    /**
     * @var string
     *
     * @ORM\Column(name="genre_p", type="string", length=255)
     */
    private $genreP;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur_p", type="string", length=255)
     */
    private $couleurP;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite_p", type="integer")
     */
    private $quantiteP;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_p", type="float")
     */
    private $prixP;

    /**
     * @var string
     *
     * @ORM\Column(name="marque_p", type="string", length=255)
     */
    private $marqueP;

    /**
     * @var int
     *
     * @ORM\Column(name="ref_c", type="integer")
     */
    private $refC;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


    /**
     * Get refP
     *
     * @return int
     */
    public function getRefP()
    {
        return $this->refP;
    }

    /**
     * Set nomP
     *
     * @param string $nomP
     *
     * @return produits
     */
    public function setNomP($nomP)
    {
        $this->nomP = $nomP;

        return $this;
    }

    /**
     * Get nomP
     *
     * @return string
     */
    public function getNomP()
    {
        return $this->nomP;
    }

    /**
     * Set genreP
     *
     * @param string $genreP
     *
     * @return produits
     */
    public function setGenreP($genreP)
    {
        $this->genreP = $genreP;

        return $this;
    }

    /**
     * Get genreP
     *
     * @return string
     */
    public function getGenreP()
    {
        return $this->genreP;
    }

    /**
     * Set couleurP
     *
     * @param string $couleurP
     *
     * @return produits
     */
    public function setCouleurP($couleurP)
    {
        $this->couleurP = $couleurP;

        return $this;
    }

    /**
     * Get couleurP
     *
     * @return string
     */
    public function getCouleurP()
    {
        return $this->couleurP;
    }

    /**
     * Set quantiteP
     *
     * @param integer $quantiteP
     *
     * @return produits
     */
    public function setQuantiteP($quantiteP)
    {
        $this->quantiteP = $quantiteP;

        return $this;
    }

    /**
     * Get quantiteP
     *
     * @return int
     */
    public function getQuantiteP()
    {
        return $this->quantiteP;
    }

    /**
     * Set prixP
     *
     * @param float $prixP
     *
     * @return produits
     */
    public function setPrixP($prixP)
    {
        $this->prixP = $prixP;

        return $this;
    }

    /**
     * Get prixP
     *
     * @return float
     */
    public function getPrixP()
    {
        return $this->prixP;
    }

    /**
     * Set marqueP
     *
     * @param string $marqueP
     *
     * @return produits
     */
    public function setMarqueP($marqueP)
    {
        $this->marqueP = $marqueP;

        return $this;
    }

    /**
     * Get marqueP
     *
     * @return string
     */
    public function getMarqueP()
    {
        return $this->marqueP;
    }

    /**
     * Set refC
     *
     * @param integer $refC
     *
     * @return produits
     */
    public function setRefC($refC)
    {
        $this->refC = $refC;

        return $this;
    }

    /**
     * Get refC
     *
     * @return int
     */
    public function getRefC()
    {
        return $this->refC;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return produits
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return produits
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
}

