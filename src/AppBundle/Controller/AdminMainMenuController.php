<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminMainMenuController extends Controller
{
    /**
     * @Route("/adminMainMenu", name="adminMainMenu")
     */
    public function menuAction(Request $request)
    {
        return $this->render('mainMenu/adminMainMenu.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

}
