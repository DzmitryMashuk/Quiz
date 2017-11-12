<?php

namespace AppBundle\Entity\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * userAnswer
 *
 * @ORM\Table(name="app_user_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserAnswerRepository")
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
     * @ORM\Column(name="id_user", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="id_quiz_question", type="integer")
     */
    private $idQuizQuestion;

//    /**
//     * @var \DateTime
//     *
//     * @ORM\Column(name="start_quiz", type="datetime")
//     */
//    private $startQuiz;

    /**
     * @var int
     *
     * @ORM\Column(name="whatQuestion", type="integer")
     */
    private $whatQuestion = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="countCorrect", type="integer")
     */
    private $countCorrect = 0;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $idQuizQuestion
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

//    /**
//     * @param \DateTime $startQuiz
//     */
//        public function setStartQuiz(\DateTime $startQuiz)
//    {
//        $this->startQuiz = $startQuiz;
//    }
//
//    /**
//     * @return \DateTime
//     */
//    public function getStartQuiz()
//    {
//        return $this->startQuiz;
//    }

    /**
     * @param int $whatQuestion
     */
    public function setWhatQuestion(int $whatQuestion)
    {
        $this->whatQuestion = $whatQuestion;
    }

    /**
     * @return int
     */
    public function getWhatQuestion()
    {
        return $this->whatQuestion;
    }

    /**
     * @param int $countCorrect
     */
    public function setCountCorrect(int $countCorrect)
    {
        $this->countCorrect = $countCorrect;
    }

    /**
     * @return int
     */
    public function getCountCorrect()
    {
        return $this->countCorrect;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}