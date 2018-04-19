<?php

namespace BDE\ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Articles
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="BDE\ShopBundle\Repository\ArticlesRepository")
 */
class Articles
{
    /**
     * @ORM\ManyToMany(targetEntity="BDE\ShopBundle\Entity\Articles_categorie", cascade={"persist"})
     */
    private $articles_categorie;


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
     * @ORM\Column(name="Name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Picture", type="string", length=255)
     */
    private $picture;


    /**
     * @var float
     *
     * @ORM\Column(name="PriceTTC", type="float")
     */
    private $priceTTC;


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
     * @return Articles
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
     * Set description
     *
     * @param string $description
     *
     * @return Articles
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

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Articles
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set priceTTC
     *
     * @param float $priceTTC
     *
     * @return Articles
     */
    public function setPriceTTC($priceTTC)
    {
        $this->priceTTC = $priceTTC;

        return $this;
    }

    /**
     * Get priceTTC
     *
     * @return float
     */
    public function getPriceTTC()
    {
        return $this->priceTTC;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles_categorie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articlesCategorie
     *
     * @param \BDE\ShopBundle\Entity\Articles_categorie $articlesCategorie
     *
     * @return Articles
     */
    public function addArticlesCategorie(\BDE\ShopBundle\Entity\Articles_categorie $articlesCategorie)
    {
        $this->articles_categorie[] = $articlesCategorie;

        return $this;
    }

    /**
     * Remove articlesCategorie
     *
     * @param \BDE\ShopBundle\Entity\Articles_categorie $articlesCategorie
     */
    public function removeArticlesCategorie(\BDE\ShopBundle\Entity\Articles_categorie $articlesCategorie)
    {
        $this->articles_categorie->removeElement($articlesCategorie);
    }

    /**
     * Get articlesCategorie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticlesCategorie()
    {
        return $this->articles_categorie;
    }
}
