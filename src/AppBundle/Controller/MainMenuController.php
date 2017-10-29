<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainMenuController extends Controller
{
    /**
     * @Route("/mainmenu", name="mainmenu")
     */
    public function menuAction(Request $request)
    {
        return $this->render('mainmenu/mainmenu.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

}
