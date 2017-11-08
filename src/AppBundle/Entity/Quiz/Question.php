<?php

namespace AppBundle\Entity\Quiz;

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

    /**
     * @ORM\Column(type="boolean")
     */
    private $finishQuestion;

    public function __construct()
    {
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
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion(string $question)
    {
        $this->question = $question;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param boolean $finishQuestion
     */
    public function setFinishQuestion($finishQuestion)
    {
        $this->finishQuestion = $finishQuestion;
    }

    /**
     * @return boolean
     */
    public function getFinishQuestion()
    {
        return $this->finishQuestion;
    }
}