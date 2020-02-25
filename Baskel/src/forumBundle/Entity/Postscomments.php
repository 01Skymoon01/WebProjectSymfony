<?php

namespace forumBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Postscomments
 *
 * @ORM\Table(name="postscomments", indexes={@ORM\Index(name="idPost", columns={"idPost"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity
 */
class Postscomments implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", length=65535, nullable=false)
     */
    private $commentaire;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="postedOn", type="datetime", length=50, nullable=false)
     */
    private $postedon;

    /**
     * @var Postsforum
     *
     * @ORM\ManyToOne(targetEntity="Postsforum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPost", referencedColumnName="id")
     * })
     */
    private $idpost;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Postscomments
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set postedon
     *
     * @param string $postedon
     *
     * @return Postscomments
     */
    public function setPostedon($postedon)
    {
        $this->postedon = $postedon;

        return $this;
    }

    /**
     * Get postedon
     *
     * @return string
     */
    public function getPostedon()
    {
        return $this->postedon;
    }

    /**
     * Set idpost
     *
     * @param \forumBundle\Entity\Postsforum $idpost
     *
     * @return Postscomments
     */
    public function setIdpost(\forumBundle\Entity\Postsforum $idpost = null)
    {
        $this->idpost = $idpost;

        return $this;
    }

    /**
     * Get idpost
     *
     * @return \forumBundle\Entity\Postsforum
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * Set iduser
     *
     * @param \AppBundle\Entity\User $iduser
     *
     * @return Postscomments
     */
    public function setIduser(\AppBundle\Entity\User $iduser = null)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \AppBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    public function notificationsOnCreate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnCreate() method.
        $notification = new Notifications();
        $notification
            ->setTitle($this->getIduser()->getUsername())
            ->setDescription($this->getIdpost()->getSubject())
            ->setRoute('forum_view_single')
            ->setParameters(array('id'=>$this->getIdpost()))
        ;
        $builder->addNotification($notification);
        //dump($this->getIdpost()->getId());
        dump($builder);
        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnUpdate() method.
        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // TODO: Implement notificationsOnDelete() method.
        return $builder;
    }


}
