<?php
// src/AppBundle/Entity/User.php

namespace BaskelBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="cin", type="integer")
     */
    protected $cin;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $addresse;
    /**
     * @ORM\Column(type="integer")
     */
    protected $numtel;
    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    protected $sexe;

    /**
     * User constructor.
     * @param int $cin
     * @param string $nom
     * @param string $prenom
     * @param string $addresse
     * @param $numtel
     * @param string $sexe
     */
    public function __construct(int $cin, string $nom, string $prenom, string $addresse, $numtel, string $sexe)
    {
        parent::__construct();
        $this->cin = $cin;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->addresse = $addresse;
        $this->numtel = $numtel;
        $this->sexe = $sexe;
    }

    /**
     * @return int
     */
    public function getCin(): int
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin(int $cin): void
    {
        $this->cin = $cin;
    }

    /**
     * @return string
     */
    public function getAddresse(): string
    {
        return $this->addresse;
    }

    /**
     * @param string $addresse
     */
    public function setAddresse(string $addresse): void
    {
        $this->addresse = $addresse;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNumtel()
    {
        return $this->numtel;
    }

    /**
     * @param mixed $numtel
     */
    public function setNumtel($numtel): void
    {
        $this->numtel = $numtel;
    }

    /**
     * @return string
     */
    public function getSexe(): string
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe(string $sexe): void
    {
        $this->sexe = $sexe;
    }

    /*public function __construct()
    {

        // your own logic
    }*/
}