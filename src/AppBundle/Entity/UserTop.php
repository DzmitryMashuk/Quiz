<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserTop
 *
 * @ORM\Table(name="app_user_top")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserTopRepository")
 */
class UserTop
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
     * @ORM\Column(name="quizName", type="string")
     */
    private $quizName;

    /**
     * @var int
     *
     * @ORM\Column(name="idUser", type="integer")
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="countPoints", type="integer")
     */
    private $countPoints;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $quizName
     */
    public function setQuizName($quizName)
    {
        $this->quizName = $quizName;
    }

    /**
     * @return string
     */
    public function getQuizName()
    {
        return $this->quizName;
    }

    /**
     * @param integer $idUser
     */
    public function setIdUser($idUser)
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

    /**
     * @param integer $countPoints
     */
    public function setCountPoints($countPoints)
    {
        $this->countPoints = $countPoints;
    }

    /**
     * @return int
     */
    public function getCountPoints()
    {
        return $this->countPoints;
    }
}

