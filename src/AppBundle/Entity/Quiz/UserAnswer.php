<?php

namespace AppBundle\Entity\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * userAnswer
 *
 * @ORM\Table(name="app_user_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\userAnswerRepository")
 */
class UserAnswer
{
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
     * @ORM\Column(name="id_quiz_question", type="integer")
     */
    private $idQuizQuestion;

    /**
     * @var int
     *
     * @ORM\Column(name="id_answer", type="integer")
     */
    private $idAnswer;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_quiz", type="datetime")
     */
    private $startQuiz;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $idQuizQuestion
     */
    public function setIdQuizQuestion(int $idQuizQuestion)
    {
        $this->idQuizQuestion = $idQuizQuestion;
    }

    /**
     * @return int
     */
    public function getIdQuizQuestion()
    {
        return $this->idQuizQuestion;
    }

    /**
     * @param integer $idAnswer
     */
    public function setIdAnswer(int $idAnswer)
    {
        $this->idAnswer = $idAnswer;
    }

    /**
     * @return int
     */
    public function getIdAnswer()
    {
        return $this->idAnswer;
    }

    /**
     * @param \DateTime $startQuiz
     */
    public function setStartQuiz(\DateTime $startQuiz)
    {
        $this->startQuiz = $startQuiz;
    }

    /**
     * @return \DateTime
     */
    public function getStartQuiz()
    {
        return $this->startQuiz;
    }
}

