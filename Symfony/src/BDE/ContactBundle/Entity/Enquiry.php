<?php
/**
 * Created by PhpStorm.
 * User: CaSSoSSiSSe
 * Date: 10/04/2018
 * Time: 09:56
 */

namespace BDE\ContactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Enquiry
{
    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="string")
     */
    protected $subject;

    /**
     * @ORM\Column(type="string")
     */
    protected $body;


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }
}