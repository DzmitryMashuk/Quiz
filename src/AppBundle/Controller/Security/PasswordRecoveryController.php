<?php

declare(strict_types=1);

namespace AppBundle\Controller\Security;

use AppBundle\Entity\User;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\PasswordRecoveryType;
use AppBundle\Service\EmailManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordRecoveryController extends Controller
{
    /**
     * @Route("/passwordRecovery", name="passwordRecovery")
     */
    public function passwordRecoveryAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(PasswordRecoveryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(['email' => $formData['email']]);
            if($user != null) {
                EmailManager::sendMail($mailer, $user->getEmail(), $this->renderView(
                    'registration/passwordEmail.html.twig', array(
                    'id' => $user->getId(),
                )));
            }

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'security/passwordRecovery.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/changePassword", name="changePassword")
     */
    public function changePasswordAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $userId = $request->get('id');
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $userForChange = $em->getRepository(User::class)->find($userId);
            $user = new User();
            $passwordEncoder = $passwordEncoder->encodePassword($user, $formData['Password']);
            $userForChange->setPassword($passwordEncoder);
            $em->persist($userForChange);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render(
            'security/changePassword.html.twig',
            array('form' => $form->createView())
        );
    }
}