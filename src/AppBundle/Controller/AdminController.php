<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     *
     */
    public function adminAction(): Response
    {
        return new Response('Admin page');
    }


    /**
     * @Route("/logout")
     */
    public function logoutAction() : Response{
        return new Response("Hello");
    }
}