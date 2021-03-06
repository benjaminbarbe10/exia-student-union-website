<?php

namespace BDE\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventRegister
 *
 * @ORM\Table(name="event_register")
 * @ORM\Entity(repositoryClass="BDE\EventBundle\Repository\RegisterEventRepository")
 */
class Event_register
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
     * @ORM\ManyToOne(targetEntity="BDE\AccountBundle\Entity\Users", cascade={"persist"})
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="BDE\EventBundle\Entity\Events", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $events;

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
     * Set users
     *
     * @param \BDE\AccountBundle\Entity\Users $users
     *
     * @return Event_register
     */
    public function setUsers(\BDE\AccountBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \BDE\AccountBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set events
     *
     * @param \BDE\EventBundle\Entity\Events $events
     *
     * @return Event_register
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
