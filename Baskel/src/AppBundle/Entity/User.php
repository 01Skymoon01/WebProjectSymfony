<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 2/8/2020
 * Time: 11:15 PM
 */

namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    private $nom;
    /**
     * @ORM\Column(type="string")
     */
    private $prenom;
    /**
     * @ORM\Column(type="date")
     */
    private $dateNaiss;
    /**
     * @ORM\Column(type="float")
     */
    private $solde=0;
    /**
     * @ORM\Column(type="string")
     */
    private $etat="en attente";
    /**
     * @ORM\Column(type="string")
     */
    private $numtel1;
    /**
     * @ORM\Column(type="string", nullable= true)
     */
    private $numtel2;





    /**
     * @return mixed
     */
    public function getDateNaiss()
    {
        return $this->dateNaiss;
    }

    /**
     * @param mixed $dateNaiss
     */
    public function setDateNaiss($dateNaiss)
    {
        $this->dateNaiss = $dateNaiss;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNumtel1()
    {
        return $this->numtel1;
    }

    /**
     * @param mixed $numtel1
     */
    public function setNumtel1($numtel1)
    {
        $this->numtel1 = $numtel1;
    }

    /**
     * @return mixed
     */
    public function getNumtel2()
    {
        return $this->numtel2;
    }

    /**
     * @param mixed $numtel2
     */
    public function setNumtel2($numtel2)
    {
        $this->numtel2 = $numtel2;
    }

    /**
     * @return mixed
     */
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * @param mixed $solde
     */
    public function setSolde($solde)
    {
        $this->solde = $solde;
    }


}