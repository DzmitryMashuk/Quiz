<?php

namespace AppBundle\Entity\Quiz;

use Doctrine\ORM\Mapping as ORM;

/**
 * Quiz
 *
 * @ORM\Table(name="app_quiz")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuizRepository")
 */
class Quiz
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
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="leaderFirst", type="string", length=25)
     */
    private $leaderFirst;

    /**
     * @var string
     *
     * @ORM\Column(name="leaderSecond", type="string", length=25)
     */
    private $leaderSecond;

    /**
     * @var string
     *
     * @ORM\Column(name="leaderThird", type="string", length=25)
     */
    private $leaderThird;

    /**
     * @var bool
     *
     * @ORM\Column(name="block", type="boolean")
     */
    private $block;

    /**
     * @var int
     *
     * @ORM\Column(name="finishQuestion", type="integer")
     */
    private $finishQuestion;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param boolean $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $leaderFirst
     */
    public function setLeaderFirst($leaderFirst)
    {
        $this->leaderFirst = $leaderFirst;
    }

    /**
     * @return string
     */
    public function getLeaderFirst()
    {
        return $this->leaderFirst;
    }

    /**
     * @param string $leaderSecond
     */
    public function setLeaderSecond($leaderSecond)
    {
        $this->leaderSecond = $leaderSecond;
    }

    /**
     * @return string
     */
    public function getLeaderSecond()
    {
        return $this->leaderSecond;
    }

    /**
     * @param string $leaderThird
     */
    public function setLeaderThird($leaderThird)
    {
        $this->leaderThird = $leaderThird;
    }

    /**
     * @return string
     */
    public function getLeaderThird()
    {
        return $this->leaderThird;
    }

    /**
     * @param boolean $block
     */
    public function setBlock($block)
    {
        $this->block = $block;

    }

    /**
     * @return bool
     */
    public function getBlock()
    {
        return $this->block;
    }

    /**
     * @param integer $finishQuestion
     */
    public function setFinishQuestion($finishQuestion)
    {
        $this->finishQuestion = $finishQuestion;
    }

    /**
     * @return integer
     */
    public function getFinishQuestion()
    {
        return $this->finishQuestion;
    }
}

