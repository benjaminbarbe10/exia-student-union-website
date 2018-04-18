<?php

namespace BDE\AccountBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BDE\AdminBundle\Entity\Role;
/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="BDE\AccountBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\ManyToOne(targetEntity="BDE\AdminBundle\Entity\Role",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $role;

    public function initRole($em) {


        // Initialise le role par defaut (identifiant 1 en bdd)
        $role = $em->getRepository(Role::class)->find(1);
        $this->role = $role;

        // Retourne l'instance de l'objet (fluent)
        return $this;
    }


    /**
     * @ORM\ManyToMany(targetEntity="BDE\EventBundle\Entity\Events_picture", cascade={"persist"})
     */
    protected $events_picture;

    /**
     * @ORM\ManyToMany(targetEntity="BDE\ShopBundle\Entity\Orders_line", cascade={"persist"})
     */
    protected $orders_line;

    /**
     * @ORM\ManyToMany(targetEntity="BDE\EventBundle\Entity\Events_picture_comment", cascade={"persist"})
     */
    protected $events_picture_comment;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Surname", type="string", length=255)
     */
    protected $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="Password", type="string", length=255)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, unique=true)
     */
    protected $email;


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
     * Set name
     *
     * @param string $name
     *
     * @return Users
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Users
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function setRole(Role $role)
    {
        $this->role = $role;

        return $this;
    }


    public function getRole()
    {
        return $this->role;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        //parent::__construct();
    }

    /**
     * Add event
     *
     * @param \BDE\EventBundle\Entity\Events $event
     *
     * @return Users
     */
    public function addEvent(\BDE\EventBundle\Entity\Events $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * Remove event
     *
     * @param \BDE\EventBundle\Entity\Events $event
     */
    public function removeEvent(\BDE\EventBundle\Entity\Events $event)
    {
        $this->events->removeElement($event);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add eventsPicture
     *
     * @param \BDE\EventBundle\Entity\Events_picture $eventsPicture
     *
     * @return Users
     */
    public function addEventsPicture(\BDE\EventBundle\Entity\Events_picture $eventsPicture)
    {
        $this->events_picture[] = $eventsPicture;

        return $this;
    }

    /**
     * Remove eventsPicture
     *
     * @param \BDE\EventBundle\Entity\Events_picture $eventsPicture
     */
    public function removeEventsPicture(\BDE\EventBundle\Entity\Events_picture $eventsPicture)
    {
        $this->events_picture->removeElement($eventsPicture);
    }

    /**
     * Get eventsPicture
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventsPicture()
    {
        return $this->events_picture;
    }

    /**
     * Add ordersLine
     *
     * @param \BDE\ShopBundle\Entity\Orders_line $ordersLine
     *
     * @return Users
     */
    public function addOrdersLine(\BDE\ShopBundle\Entity\Orders_line $ordersLine)
    {
        $this->orders_line[] = $ordersLine;

        return $this;
    }

    /**
     * Remove ordersLine
     *
     * @param \BDE\ShopBundle\Entity\Orders_line $ordersLine
     */
    public function removeOrdersLine(\BDE\ShopBundle\Entity\Orders_line $ordersLine)
    {
        $this->orders_line->removeElement($ordersLine);
    }

    /**
     * Get ordersLine
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrdersLine()
    {
        return $this->orders_line;
    }

}
