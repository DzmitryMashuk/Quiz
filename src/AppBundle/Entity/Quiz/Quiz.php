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
     * @return Quiz
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
     * Set status
     *
     * @param boolean $status
     *
     * @return Quiz
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set leaderFirst
     *
     * @param string $leaderFirst
     *
     * @return Quiz
     */
    public function setLeaderFirst($leaderFirst)
    {
        $this->leaderFirst = $leaderFirst;

        return $this;
    }

    /**
     * Get leaderFirst
     *
     * @return string
     */
    public function getLeaderFirst()
    {
        return $this->leaderFirst;
    }

    /**
     * Set leaderSecond
     *
     * @param string $leaderSecond
     *
     * @return Quiz
     */
    public function setLeaderSecond($leaderSecond)
    {
        $this->leaderSecond = $leaderSecond;

        return $this;
    }

    /**
     * Get leaderSecond
     *
     * @return string
     */
    public function getLeaderSecond()
    {
        return $this->leaderSecond;
    }

    /**
     * Set leaderThird
     *
     * @param string $leaderThird
     *
     * @return Quiz
     */
    public function setLeaderThird($leaderThird)
    {
        $this->leaderThird = $leaderThird;

        return $this;
    }

    /**
     * Get leaderThird
     *
     * @return string
     */
    public function getLeaderThird()
    {
        return $this->leaderThird;
    }

    /**
     * Set block
     *
     * @param boolean $block
     *
     * @return Quiz
     */
    public function setBlock($block)
    {
        $this->block = $block;

        return $this;
    }

    /**
     * Get block
     *
     * @return bool
     */
    public function getBlock()
    {
        return $this->block;
    }
}

