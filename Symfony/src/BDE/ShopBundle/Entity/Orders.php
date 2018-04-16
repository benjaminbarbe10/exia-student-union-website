<?php

namespace BDE\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="BDE\ShopBundle\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @ORM\ManyToOne(targetEntity="BDE\AccountBundle\Entity\Users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_order", type="string")
     */
    private $date;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Orders
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
     * Set users
     *
     * @param \BDE\AccountBundle\Entity\Users $users
     *
     * @return Orders
     */
    public function setUsers(\BDE\AccountBundle\Entity\Users $users)
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
}
