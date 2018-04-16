<?php

namespace BDE\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart")
 * @ORM\Entity(repositoryClass="BDE\ShopBundle\Repository\CartRepository")
 */
class Cart
{

    /**
     * @ORM\ManyToOne(targetEntity="BDE\ShopBundle\Entity\Articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * Get articles
     *
     * @return \BDE\ShopBundle\Entity\Articles
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set articles
     *
     * @param \BDE\ShopBundle\Entity\Articles $articles
     *
     * @return Cart
     */
    public function setArticles(\BDE\ShopBundle\Entity\Articles $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Set users
     *
     * @param \BDE\AccountBundle\Entity\Users $users
     *
     * @return Cart
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
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Cart
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }
}

