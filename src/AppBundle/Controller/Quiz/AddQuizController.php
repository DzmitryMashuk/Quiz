<?php
namespace AppBundle\Controller\Quiz;
use AppBundle\Form\QuizType;
use AppBundle\Entity\Quiz\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class AddQuizController extends Controller
{
    /**
     * @Route("/adminAddQuiz", name="adminAddQuiz")
     */
    public function questionAction(Request $request)
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $quiz->setLeaderFirst(1);
            $quiz->setLeaderSecond(1);
            $quiz->setLeaderThird(1);
            $quiz->setStatus(true);
            $quiz->setBlock(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute("adminAddQuestion");
        }
        return $this->render(
            'admin/adminAddQuiz.html.twig',
            array('form' => $form->createView())
        );
    }
}