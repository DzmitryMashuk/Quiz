<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * User controller.
 *
 * @Route("adminUserShow")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="adminUserShow_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="adminUserShow_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {

        return $this->render('user/show.html.twig', array(
            'user' => $user,
        ));
    }
}
