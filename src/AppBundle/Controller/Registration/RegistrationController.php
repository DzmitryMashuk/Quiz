<?php

namespace AppBundle\Controller\Registration;

use AppBundle\Form\RegistrationType;
use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\EmailManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            EmailManager::sendMail($mailer, $user->getEmail(), $this->renderView(
                'registration/email.html.twig', array(
                'id' => $user->getId(),
                'userName' => $user->getUsername()
            )));

            return $this->redirectToRoute("login");
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/email/{id}", name="email")
     */
    public function emailAction(Request $request)
    {
        $userId = $request->get('id');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($userId);
        $user->setActive(true);
        $em->flush();

        return $this->redirectToRoute('login');
    }
}
