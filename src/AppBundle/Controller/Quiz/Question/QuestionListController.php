<?php

namespace AppBundle\Controller\Quiz\Question;


use AppBundle\Entity\Quiz\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class QuestionListController extends Controller
{
    /**
     * @Route("/quizList", name="quizList")
     * @Method("GET")
     */
    public function questionListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $question = $em->getRepository(Question::class)->findAll();

        return $this->render('admin/adminAddQuestion.html.twig', array(
            'question' => $question,
        ));
    }

}