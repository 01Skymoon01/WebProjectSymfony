<?php

namespace FriteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="FriteBundle\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idR", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idR;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateR", type="date")
     */
    private $dateR;

    public function __construct()
    {
        $this->dateR = new \DateTime();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="objetR", type="string", length=255)
     */
    private $objetR;

    /**
     * @var string
     *
     * @ORM\Column(name="etatR", type="string", length=255)
     */
    private $etatR;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="detailsR", type="string", length=255)
     */
    private $detailsR;

    /**
     * @return int
     */
    public function getIdR()
    {
        return $this->idR;
    }

    /**
     * @param int $idR
     */
    public function setIdR($idR)
    {
        $this->idR = $idR;
    }

    /**
     * @ORM\ManyToOne(targetEntity="FriteBundle\Entity\User")
     * @ORM\JoinColumn(name="userid",referencedColumnName="id")
     */
    private $userid;

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

    /**
     * Set dateR
     *
     * @param \DateTime $dateR
     *
     * @return Reclamation
     */
    public function setDateR($dateR)
    {
        $this->dateR = $dateR;

        return $this;
    }

    /**
     * Get dateR
     *
     * @return \DateTime
     */
    public function getDateR()
    {
        return $this->dateR;
    }

    /**
     * Set objetR
     *
     * @param string $objetR
     *
     * @return Reclamation
     */
    public function setObjetR($objetR)
    {
        $this->objetR = $objetR;

        return $this;
    }

    /**
     * Get objetR
     *
     * @return string
     */
    public function getObjetR()
    {
        return $this->objetR;
    }

    /**
     * Set etatR
     *
     * @param string $etatR
     *
     * @return Reclamation
     */
    public function setEtatR($etatR)
    {
        $this->etatR = $etatR;

        return $this;
    }

    /**
     * Get etatR
     *
     * @return string
     */
    public function getEtatR()
    {
        return $this->etatR;
    }

    /**
     * Set detailsR
     *
     * @param string $detailsR
     *
     * @return Reclamation
     */
    public function setDetailsR($detailsR)
    {
        $this->detailsR = $detailsR;

        return $this;
    }

    /**
     * Get detailsR
     *
     * @return string
     */
    public function getDetailsR()
    {
        return $this->detailsR;
    }
}

