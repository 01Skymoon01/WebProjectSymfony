<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\ContratRepository")
 */
class Contrat
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
     * @var float
     *
     * @ORM\Column(name="Pack", type="float", nullable=true)
     */
    private $pack;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;



    /**
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event")
     * @ORM\JoinColumn(name="id_event",referencedColumnName="id")
     */

    private $id_event;

    /**
     * @return mixed
     */
    public function getIdEvent()
    {
        return $this->id_event;
    }

    /**
     * @param mixed $id_event
     */
    public function setIdEvent($id_event)
    {
        $this->id_event = $id_event;
    }

    /**
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Partenaire")
     * @ORM\JoinColumn(name="id_partenaire",referencedColumnName="id")
     */

    private $id_partenaire;

    /**
     * @return mixed
     */
    public function getIdPartenaire()
    {
        return $this->id_partenaire;
    }

    /**
     * @param mixed $id_partenaire
     */
    public function setIdPartenaire($id_partenaire)
    {
        $this->id_partenaire = $id_partenaire;
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
     * Set pack
     *
     * @param float $pack
     *
     * @return Contrat
     */
    public function setPack($pack)
    {
        $this->pack = $pack;

        return $this;
    }

    /**
     * Get pack
     *
     * @return float
     */
    public function getPack()
    {
        return $this->pack;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Contrat
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

