<?php

namespace BDE\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events_picture_comment
 *
 * @ORM\Table(name="events_picture_comment")
 * @ORM\Entity(repositoryClass="BDE\EventBundle\Repository\Events_picture_commentRepository")
 */
class Events_picture_comment
{
    /**
     * @ORM\ManyToOne(targetEntity="BDE\EventBundle\Entity\Events_picture")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event_picture;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Content", type="string", length=255)
     */
    private $content;


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
     * Set content
     *
     * @param string $content
     *
     * @return Events_picture_comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set eventPicture
     *
     * @param \BDE\EventBundle\Entity\Events_picture $eventPicture
     *
     * @return Events_picture_comment
     */
    public function setEventPicture(\BDE\EventBundle\Entity\Events_picture $eventPicture)
    {
        $this->event_picture = $eventPicture;

        return $this;
    }

    /**
     * Get eventPicture
     *
     * @return \BDE\EventBundle\Entity\Events_picture
     */
    public function getEventPicture()
    {
        return $this->event_picture;
    }
}
