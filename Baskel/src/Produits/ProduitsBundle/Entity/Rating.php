<?php

namespace Produits\ProduitsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="Produits\ProduitsBundle\Repository\RatingRepository")
 */
class Rating
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
     * @ORM\ManyToOne(targetEntity="Produits")
     * @ORM\JoinColumn(name="idProd",referencedColumnName="ref_p",nullable=false)
     */
    private $idProd;


    /**
     * @var int
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="idClient",referencedColumnName="id",nullable=false)
     */
    private $idClient;



    /**
     * @var int
     *
     * @ORM\Column(name="rate", type="integer")
     */
    private $rate;


    /**
     * @var int
     *
     * @ORM\Column(name="totalRate", type="integer")
     */
    private $totalRate;


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
     * Set idProd
     *
     * @param integer $idProd
     *
     * @return Rating
     */
    public function setIdProd($idProd)
    {
        $this->idProd = $idProd;

        return $this;
    }

    /**
     * Get idProd
     *
     * @return int
     */
    public function getIdProd()
    {
        return $this->idProd;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     *
     * @return Rating
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return int
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @return int
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param int $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return int
     */
    public function getTotalRate()
    {
        return $this->totalRate;
    }

    /**
     * @param int $totalRate
     */
    public function setTotalRate($totalRate)
    {
        $this->totalRate = $totalRate;
    }





}

