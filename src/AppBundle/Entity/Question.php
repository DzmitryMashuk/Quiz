<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @ORM\Column(type="string", length=90, unique=true)
     * @Assert\NotBlank()
     */
    private $question;

    /**
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = false;

    public function __construct()
    {
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    public function getStatus():boolean
    {
        return $this->status;
    }

    public function setStatus(boolean $status)
    {
        $this->status = $status;
    }
}