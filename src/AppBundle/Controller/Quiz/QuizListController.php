<?php

namespace AppBundle\Controller\Quiz;


use AppBundle\Entity\Quiz\Quiz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class QuizListController extends Controller
{
    /**
     * Lists all quiz entities.
     *
     * @Route("/adminMainMenu", name="adminMainMenu")
     * @Method("GET")
     */
    public function adminQuizAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findAll();

        return $this->render('mainMenu/adminMainMenu.html.twig', array(
            'quiz' => $quiz,
        ));
    }

    /**
     *
     * @Route("/userMainMenu", name="userMainMenu")
     * @Method("GET")
     */
    public function userQuizAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findAll();

        return $this->render('mainMenu/userMainMenu.html.twig', array(
            'quiz' => $quiz,
        ));
    }
}