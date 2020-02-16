<?php

namespace FriteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Technicien
 *
 * @ORM\Table(name="technicien")
 * @ORM\Entity(repositoryClass="FriteBundle\Repository\TechnicienRepository")
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

    public function __toString()
    {
        return (string) $this->getIdT();
    }
    /**
     * @var integer
     *@Assert\NotBlank
     *@Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "La CIN doit comporter 8 charactere",
     *      maxMessage = "La CIN doit comporter 8 charactere"
     * )
     * @ORM\Column(name="cin", type="integer")
     */
    private $cin;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *@Assert\NotBlank
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var int
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage="La CIN doit comporter 8 charactere",
     *     max="La CIN doit comporter 8 charactere"
     * )
     * @Assert\NotBlank(message="error")
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

