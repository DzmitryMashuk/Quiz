<?php
namespace AppBundle\Controller\Quiz\Question;
use AppBundle\Form\QuestionType;
use AppBundle\Entity\Quiz\Question;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class QuestionController extends Controller
{
    /**
     * @Route("/adminAddQuestion", name="adminAddQuestion")
     */
    public function questionAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $question->setIdNextQuestion(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute("adminAddAnswers");
        }
        return $this->render(
            'admin/adminAddQuestion.html.twig',
            array('form' => $form->createView())
        );
    }
}