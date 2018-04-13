<?php

namespace BDE\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="BDE\EventBundle\Repository\EventsRepository")
 */
class Events
{

    /*
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Ajouter une image jpg")
     * @Assert\File(mimeTypes={ "image/jpeg" })

    /*private $image;

    public function getImage()
    {
        return $this->image;
    }

    //public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }*/

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
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="Place", type="string", length=255)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=255)
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="IsApproved", type="boolean")
     */
    private $isApproved = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="PriceTTC", type="float")
     */
    private $priceTTC;

    /**
     * @ORM\ManyToMany(targetEntity="Events_picture", cascade={"persist"})
     */
    private $events_picture;

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
     * @return Events
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Events
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
     * Set place
     *
     * @param string $place
     *
     * @return Events
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Events
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
     * Set type
     *
     * @param string $type
     *
     * @return Events
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set isApproved
     *
     * @param boolean $isApproved
     *
     * @return Events
     */
    public function setIsApproved($isApproved)
    {
        $this->isApproved = $isApproved;

        return $this;
    }

    /**
     * Get isApproved
     *
     * @return bool
     */
    public function getIsApproved()
    {
        return $this->isApproved;
    }

    /**
     * Set priceTTC
     *
     * @param float $priceTTC
     *
     * @return Events
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
        $this->date           = new \DateTime();
        $this->events_picture = new ArrayCollection();
    }


    /**
     * Get events_picture
     *
     * @return ArrayCollection
     */
    function getEvents_picture() {
        return $this->events_picture;
    }

    /**
     * Set files
     * @param type $events_picture
     */
    function setEvents_picture($events_picture) {
        $this->events_picture = $events_picture;
    }



    /**
     * Add eventsPicture
     *
     * @param \BDE\EventBundle\Entity\Events_picture $eventsPicture
     *
     * @return Events
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
}
