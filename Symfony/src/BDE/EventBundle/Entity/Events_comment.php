<?php

namespace BDE\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventscomment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="BDE\EventBundle\Repository\CommentRepository")
 */
class Events_comment
{
    /**
     * @ORM\ManyToOne(targetEntity="BDE\EventBundle\Entity\Events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $events;


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
     * @ORM\Column(name="authorname", type="string", length=255)
     */
    private $authorname;

    /**
     * @var string
     *
     * @ORM\Column(name="authorsurname", type="string", length=255)
     */
    private $authorsurname;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;


    public function __construct()
    {
        $this->date = new \Datetime();
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
     * Set authorname
     *
     * @param string $authorname
     *
     * @return Eventscomment
     */
    public function setAuthorname($authorname)
    {
        $this->authorname = $authorname;

        return $this;
    }

    /**
     * Get authorname
     *
     * @return string
     */
    public function getAuthorname()
    {
        return $this->authorname;
    }

    /**
     * Set authorsurname
     *
     * @param string $authorsurname
     *
     * @return Eventscomment
     */
    public function setAuthorsurname($authorsurname)
    {
        $this->authorsurname = $authorsurname;

        return $this;
    }

    /**
     * Get authorsurname
     *
     * @return string
     */
    public function getAuthorsurname()
    {
        return $this->authorsurname;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Eventscomment
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Eventscomment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set events
     *
     * @param \BDE\EventBundle\Entity\Events $events
     *
     * @return Events_comment
     */
    public function setEvents(\BDE\EventBundle\Entity\Events $events)
    {
        $this->events = $events;

        return $this;
    }

    /**
     * Get events
     *
     * @return \BDE\EventBundle\Entity\Events
     */
    public function getEvents()
    {
        return $this->events;
    }
}
