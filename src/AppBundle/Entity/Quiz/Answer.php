<?php

declare(strict_types=1);

namespace AppBundle\Entity\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="app_answer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @var string
     *
     * @ORM\Column(name="answer1", type="string", length=50)
     */
    private $answer1;

    /**
     * @var string
     *
     * @ORM\Column(name="answer2", type="string", length=50)
     */
    private $answer2;

    /**
     * @var string
     *
     * @ORM\Column(name="answer3", type="string", length=50)
     */
    private $answer3;

    /**
     * @var string
     *
     * @ORM\Column(name="answer4", type="string", length=50)
     */
    private $answer4;

    /**
     * @var int
     *
     * @ORM\Column(name="correct", type="integer")
     */
    private $correct;

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
     * Set answer1
     *
     * @param string $answer1
     */
    public function setAnswer1($answer1)
    {
        $this->answer1 = $answer1;
    }

    /**
     * Set answer2
     *
     * @param string $answer2
     */

    public function setAnswer2($answer2)
    {
        $this->answer2 = $answer2;
    }

    /**
     * Set answer3
     *
     * @param string $answer3
     */
    public function setAnswer3($answer3)
    {
        $this->answer3 = $answer3;
    }

    /**
     * Set answer4
     *
     * @param string $answer4
     */
    public function setAnswer4($answer4)
    {
        $this->answer4 = $answer4;
    }

    /**
     * Get answer1
     *
     * @return string
     */
    public function getAnswer1()
    {
        return $this->answer1;
    }

    /**
     * Get answer2
     *
     * @return string
     */
    public function getAnswer2()
    {
        return $this->answer2;
    }

    /**
     * Get answer3
     *
     * @return string
     */
    public function getAnswer3()
    {
        return $this->answer3;
    }

    /**
     * Get answer4
     *
     * @return string
     */
    public function getAnswer4()
    {
        return $this->answer4;
    }

    /**
     * Set correct
     *
     * @param integer $correct
     */
    public function setCorrect($correct)
    {
        $this->correct = $correct;
    }

    /**
     * Get correct
     *
     * @return integer
     */
    public function getCorrect()
    {
        return $this->correct;
    }
}

