<?php

namespace AppBundle\Controller;

use AppBundle\Form\QuestionType;
use AppBundle\Entity\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    /**
     * @Route("/question", name="question")
     */
    public function registerAction(Request $request)
    {

        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute("login");
        }

        return $this->render(
            'question/question.html.twig',
            array('form' => $form->createView())
        );
    }
}