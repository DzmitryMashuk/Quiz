<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    /**
     * @Route("/question", name="question")
     */
    public function questionAction(Request $request){
        // 1) build the form
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

// 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

// 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

// ... do any other work - like sending them an email, etc
// maybe set a "flash" success message for the user

            return $this->redirectToRoute("login");
        }

        return $this->render(
            'question/question.html.twig',
            array('form' => $form->createView())
        );
    }
}