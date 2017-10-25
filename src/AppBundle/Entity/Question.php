<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="app_questions")
 * @ORM\Entity()
 */
class Question
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $question;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = false;

    public function __construct()
    {
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public  function getStatus(): boolean
    {
        return $this->status;
    }

    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    public function setStatus(boolean $status)
    {
        $this->status = $status;
    }
}