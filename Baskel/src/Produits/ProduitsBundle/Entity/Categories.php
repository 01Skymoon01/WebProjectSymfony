<?php

namespace Produits\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Categories
 *
 * @ORM\Table(name="categories", indexes={
 *     @ORM\Index(name="libelle", columns={"libelle"}),
 * })
 * @ORM\Entity(repositoryClass="Produits\ProduitsBundle\Repository\CategoriesRepository")
 * @UniqueEntity("libelle")
 */
class Categories
{
    /**
     * @var int
     *
     * @ORM\Column(name="ref_c", type="integer")
     * @ORM\Id
     * @Assert\Range(min=0, minMessage="Negative species! Come on...")
     */
    private $ref_c;



    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     * @ORM\OneToMany(targetEntity="Produits",mappedBy="libelle",
     *   cascade={
     *     "persist",
     *     "remove",
     *     "merge"
     *   },
     *   orphanRemoval=true
     * )
     */
    private $libelle;

    /**
     * @param int $ref_c
     */
    public function setRefC($ref_c)
    {
        $this -> ref_c = $ref_c;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getRefC()
    {
        return $this->ref_c;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Categories
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}

