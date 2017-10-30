<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Question;
use AppBundle\Form\QuestionType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        $error = $authUtils->getLastAuthenticationError();

        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/security.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {

    }

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        return $this->render(
            'question/question.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/user", name="user")
     */
    public function userAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        return $this->render(
            'mainMenu/mainMenu.html.twig',
            array('form' => $form->createView())
        );
    }
}