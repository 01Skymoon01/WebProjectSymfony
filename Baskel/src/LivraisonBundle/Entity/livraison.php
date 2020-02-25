<?php

namespace LivraisonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * livraison
 *
 * @ORM\Table(name="livraison")
 * @ORM\Entity(repositoryClass="LivraisonBundle\Repository\livraisonRepository")
 */
class livraison
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
     * @ORM\ManyToOne(targetEntity="LivraisonBundle\Entity\Livreur")
     * @ORM\JoinColumn(name="idLivreur",referencedColumnName="id")
     */
    private $idLivreur;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="PanierBundle\Entity\Commande")
     * @ORM\JoinColumn(name="idCommande",referencedColumnName="id")
     */

    private $idCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLivraison", type="datetime",nullable=true)
     */
    private $dateLivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="codeConf", type="string", length=255)
     */
    private $codeConf;

    /**
     * livraison constructor.
     */
    public function __construct()
    {
        $this->codeConf = $this->generateRandomString(5);
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
     * @param mixed $idLivreur
     */

    public function setIdLivreur($idLivreur)
    {
        $this->idLivreur = $idLivreur;

        return $this;
    }

    /**
     * @return  mixed
     */

    public function getIdLivreur()
    {
        return $this->idLivreur;
    }

    /**
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
     * Set dateLivraison
     *
     * @param \DateTime $dateLivraison
     *
     * @return livraison
     */
    public function setDateLivraison($dateLivraison)
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    /**
     * Get dateLivraison
     *
     * @return \DateTime
     */
    public function getDateLivraison()
    {
        return $this->dateLivraison;
    }

    /**
     * Set codeConf
     *
     * @param string $codeConf
     *
     * @return livraison
     */
    public function setCodeConf($codeConf)
    {
        $this->codeConf = $codeConf;

        return $this;
    }

    /**
     * Get codeConf
     *
     * @return string
     */
    public function getCodeConf()
    {
        return $this->codeConf;
    }

    public function generateRandomString($length = 5, $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

