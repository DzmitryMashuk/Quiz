<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\User;
use AppBundle\Form\PasswordRecoveryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PasswordRecoveryController extends Controller
{
    /**
     * @Route("/passwordRecovery", name="passwordRecovery")
     */
    public function passwordRecoveryAction(Request $request, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(PasswordRecoveryType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $message = (new \Swift_Message('Password Recovery'))
                ->setFrom('Dashoid.chern@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'registration/passwordEmail.html.twig'
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);
            return $this->redirectToRoute("login");
        }
        return $this->render(
            'security/passwordRecovery.html.twig',
            array('form' => $form->createView())
        );
    }
}