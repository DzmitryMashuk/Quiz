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
     * @var int
     *
     * @ORM\Column(name="idQuiz", type="integer")
     */
    private $idQuiz;

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
     * @param integer $idQuiz
     */
    public function setIdQuiz($idQuiz)
    {
        $this->idQuiz = $idQuiz;
    }

    /**
     * @return int
     */
    public function getIdQuiz()
    {
        return $this->idQuiz;
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

