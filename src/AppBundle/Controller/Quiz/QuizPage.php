<?php

namespace AppBundle\Controller\Quiz;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuizPage extends Controller
{
    /**
     * @Route("/quizPage", name="quizPage")
     */
    public function menuAction(Request $request)
    {
        return $this->render('quiz/quizPage.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }
}
