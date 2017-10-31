<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainMenuController extends Controller
{
    /**
     * @Route("/mainMenu", name="mainMenu")
     */
    public function menuAction(Request $request)
    {
        return $this->render('mainMenu/mainMenu.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);


    }

}
