<?php

namespace BaskelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technicien
 *
 * @ORM\Table(name="technicien")
 * @ORM\Entity(repositoryClass="BaskelBundle\Repository\TechnicienRepository")
 */
class Technicien
{
    /**
     * @var int
     *
     * @ORM\Column(name="idT", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idT;

    /**
     * @var integer
     *
     * @ORM\Column(name="cin", type="integer")
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="numtel", type="integer")
     */
    private $numtel;

    /**
     * @return int
     */
    public function getIdT()
    {
        return $this->idT;
    }

    /**
     * @param int $idT
     */
    public function setIdT($idT)
    {
        $this->idT = $idT;
    }

    /**
     * @return int
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * @param int $cin
     */
    public function setCin($cin)
    {
        $this->cin = $cin;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Technicien
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Technicien
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Technicien
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set numtel
     *
     * @param integer $numtel
     *
     * @return Technicien
     */
    public function setNumtel($numtel)
    {
        $this->numtel = $numtel;

        return $this;
    }

    /**
     * Get numtel
     *
     * @return int
     */
    public function getNumtel()
    {
        return $this->numtel;
    }
}

