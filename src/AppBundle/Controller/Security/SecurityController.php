<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Quiz\Question;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
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
     * @Route("/goAdminPanel", name="goAdminPanel")
     */
    public function goAdminPanelAction(Request $request)
    {
        $username = $request->get('username');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['username' => $username]);

        if ($user != null){

            if ($user->getRoles() == ['ROLE_ADMIN']){

                return $this->redirectToRoute('adminMainMenu');
            }else{
                echo "<script>alert(\"You don't have access rights\");</script>";

                return $this->redirectToRoute('userMainMenu');
            }
        }
    }
}