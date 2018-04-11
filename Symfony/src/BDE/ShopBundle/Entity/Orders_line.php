<?php

namespace BDE\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders_line
 *
 * @ORM\Table(name="orders_line")
 * @ORM\Entity(repositoryClass="BDE\ShopBundle\Repository\Orders_lineRepository")
 */
class Orders_line
{
    /**
     * @ORM\ManyToOne(targetEntity="BDE\ShopBundle\Entity\Orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orders;

    /**
     * @ORM\ManyToOne(targetEntity="BDE\ShopBundle\Entity\Articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $articles;

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
     * @ORM\Column(name="Quantity", type="integer")
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="UnityPriceTTC", type="float")
     */
    private $unityPriceTTC;

    /**
     * @var string
     *
     * @ORM\Column(name="ArticleName", type="string", length=255)
     */
    private $articleName;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Orders_line
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
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
     * Set unityPriceTTC
     *
     * @param float $unityPriceTTC
     *
     * @return Orders_line
     */
    public function setUnityPriceTTC($unityPriceTTC)
    {
        $this->unityPriceTTC = $unityPriceTTC;

        return $this;
    }

    /**
     * Get unityPriceTTC
     *
     * @return float
     */
    public function getUnityPriceTTC()
    {
        return $this->unityPriceTTC;
    }

    /**
     * Set articleName
     *
     * @param string $articleName
     *
     * @return Orders_line
     */
    public function setArticleName($articleName)
    {
        $this->articleName = $articleName;

        return $this;
    }

    /**
     * Get articleName
     *
     * @return string
     */
    public function getArticleName()
    {
        return $this->articleName;
    }

    /**
     * Set orders
     *
     * @param \BDE\ShopBundle\Entity\Orders $orders
     *
     * @return Orders_line
     */
    public function setOrders(\BDE\ShopBundle\Entity\Orders $orders)
    {
        $this->orders = $orders;

        return $this;
    }

    /**
     * Get orders
     *
     * @return \BDE\ShopBundle\Entity\Orders
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Set articles
     *
     * @param \BDE\ShopBundle\Entity\Articles $articles
     *
     * @return Orders_line
     */
    public function setArticles(\BDE\ShopBundle\Entity\Articles $articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles
     *
     * @return \BDE\ShopBundle\Entity\Articles
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
