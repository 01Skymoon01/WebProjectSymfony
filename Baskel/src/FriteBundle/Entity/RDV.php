<?php

namespace FriteBundle\Entity;

use AncaRebeca\FullCalendarBundle\FullCalendarBundle;
use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;
use Doctrine\ORM\Mapping as ORM;
use FriteBundle\Repository\CalendarEventRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RDV
 *
 * @ORM\Table(name="r_d_v")
 * @ORM\Entity(repositoryClass="FriteBundle\Repository\RDVRepository")
 */
class RDV
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRDV", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idRDV;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeptRDV", type="date")
     */
    private $dateDepotRDV;

    /**
     * @return \DateTime
     */
    public function getDateDepotRDV()
    {
        return $this->dateDepotRDV;
    }

    /**
     * @param \DateTime $dateDepotRDV
     */
    public function setDateDepotRDV($dateDepotRDV)
    {
        $this->dateDepotRDV = $dateDepotRDV;
    }

    public function __construct()
    {
        $this->dateDepotRDV = new \DateTime();

    }
    /**
     * @var \DateTime
     *
     *
     *
     * @ORM\Column(name="dateRDV", type="date")
     */
    private $dateRDV;

    /**
     * @var string
     * @ORM\Column(name="objetRDV", type="string", length=255)
     */
    private $objetRDV;

    /**
     * @var string
     *
     * @ORM\Column(name="etatRDV", type="string", length=255)
     */
    private $etatRDV;

    /**
     * @var string
     * @ORM\Column(name="detailsRDV", type="string", length=255)
     */
    private $detailsRDV;

    /**
     * @ORM\ManyToOne(targetEntity="FriteBundle\Entity\Technicien")
     * @ORM\JoinColumn(name="technicienid",referencedColumnName="idT", nullable=true)
     */
    private $technicienid;

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
     * @return mixed
     */
    public function getTechnicienid()
    {
        return $this->technicienid;
    }

    /**
     * @param mixed $technicienid
     */
    public function setTechnicienid($technicienid)
    {
        $this->technicienid = $technicienid;
    }

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="userid",referencedColumnName="id")
     */
    private $userid;

    /**
     * @return int
     */
    public function getIdRDV()
    {
        return $this->idRDV;
    }

    /**
     * @param int $idRDV
     */
    public function setIdRDV($idRDV)
    {
        $this->idRDV = $idRDV;
    }


    /**
     * Set dateRDV
     *
     * @param \DateTime $dateRDV
     *
     * @return RDV
     */
    public function setDateRDV($dateRDV)
    {
        $this->dateRDV = $dateRDV;

        return $this;
    }

    /**
     * Get dateRDV
     *
     * @return \DateTime
     */
    public function getDateRDV()
    {
        return $this->dateRDV;
    }

    /**
     * Set objetRDV
     *
     * @param string $objetRDV
     *
     * @return RDV
     */
    public function setObjetRDV($objetRDV)
    {
        $this->objetRDV = $objetRDV;

        return $this;
    }

    /**
     * Get objetRDV
     *
     * @return string
     */
    public function getObjetRDV()
    {
        return $this->objetRDV;
    }

    /**
     * Set etatRDV
     *
     * @param string $etatRDV
     *
     * @return RDV
     */
    public function setEtatRDV($etatRDV)
    {
        $this->etatRDV = $etatRDV;

        return $this;
    }

    /**
     * Get etatRDV
     *
     * @return string
     */
    public function getEtatRDV()
    {
        return $this->etatRDV;
    }

    /**
     * Set detailsRDV
     *
     * @param string $detailsRDV
     *
     * @return RDV
     */
    public function setDetailsRDV($detailsRDV)
    {
        $this->detailsRDV = $detailsRDV;

        return $this;
    }

    /**
     * Get detailsRDV
     *
     * @return string
     */
    public function getDetailsRDV()
    {
        return $this->detailsRDV;
    }
}

