<?php

namespace AppBundle\Controller\Quiz\Question;

use AppBundle\Form\AnswerType;
use AppBundle\Entity\Quiz\Answer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnswerController extends Controller
{
    /**
     * @Route("/adminAddAnswers", name="adminAddAnswers")
     */
    public function answerAction(Request $request)
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setIdQuestion(1);
            $answer->setCorrect(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute("adminAddQuestion");
        }

        return $this->render(
            'admin/adminAddAnswers.html.twig',
            array('form' => $form->createView())
        );
    }
}