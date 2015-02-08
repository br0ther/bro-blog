<?php
// src/Blogger/BlogBundle/Entity/Enquiry.php

namespace BRO\BlogBundle\Entity;

/*
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;
*/
use Symfony\Component\Validator\Constraints as Assert;

class Enquiry
{
    /**
    * @Assert\NotBlank()
    */
    protected $name;
    
    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    protected $email;
    
    /**
     * @Assert\Length(
     *      min = "2",
     *      max = "50",
     *      minMessage = "Your subject must be at least {{ limit }} characters length",
     *      maxMessage = "Your subject cannot be longer than {{ limit }} characters length"
     * )
     * @Assert\NotBlank()
     */
    protected $subject;
    
    /**
     * @Assert\Length(
     *      min = "10",
     *      minMessage = "Your subject must be at least {{ limit }} characters length"
     * )
     * @Assert\NotBlank()
     */
    protected $body;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

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
    /*
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank());

        $metadata->addPropertyConstraint('email', new Email(array(
    'message' => 'symblog does not like invalid emails. Give me a real one!'
)));

        $metadata->addPropertyConstraint('subject', new NotBlank());
        $metadata->addPropertyConstraint('subject', new MaxLength(50));

        $metadata->addPropertyConstraint('body', new MinLength(50));
    }
    */
}

