<?php

namespace BaskelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Produits
 *
 * @ORM\Table(name="produits")
 * @ORM\Entity(repositoryClass="BaskelBundle\Repository\ProduitsRepository")
 */
class Produits
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_p", type="integer")
     * @ORM\Id
     */
    private $ref_p;

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
     * @var array
     *
     * @ORM\Column(name="couleur_p", type="json_array", length=255)
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
     * @var
     * @ORM\ManyToOne(targetEntity="Categories")
     * @ORM\JoinColumn(name="ref_c",referencedColumnName="ref_c",nullable=false)
     */
    private $ref_c;


    /**
     * @var text
     *
     * @ORM\Column(name="description", type="text", length=255)
     */
    private $description;

























    /**
     * @param int $ref_p
     */
    public function setRefP($ref_p)
    {
        $this -> ref_p = $ref_p;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getRefP()
    {
        return $this->ref_p;
    }

    /**
     * Set nomP
     *
     * @param string $nomP
     *
     * @return Produits
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
     * @return Produits
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
     * @return Produits
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
     * @return Produits
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
     * @return Produits
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
     * @return Produits
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
     * @return mixed
     */
    public function getRefC()
    {
        return $this -> ref_c;
    }



    /**
     * @param mixed $ref_c
     */
    public function setRefC($ref_c)
    {
        $this -> ref_c = $ref_c;
    }

    /**
     * @return text
     */
    public function getDescription()
    {
        return $this -> description;
    }

    /**
     * @param text $description
     */
    public function setDescription($description)
    {
        $this -> description = $description;
    }

















    /**
     * @var string
     * @Assert\NotBlank(message="Upload your image")
     * @Assert\Image()
     * @ORM\Column(name="image",type="string" ,length=255)
     */
    private $image;

    /**
     * @return string
     */
    public function getImage()
    {
        return $this -> image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this -> image = $image;
    }






}

