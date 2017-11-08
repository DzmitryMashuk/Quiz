<?php

namespace AppBundle\Controller\Quiz;

use AppBundle\Entity\Quiz\QuizQuestion;
use AppBundle\Form\QuestionType;
use AppBundle\Form\QuizType;
use AppBundle\Entity\Quiz\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Quiz\Question;

class QuizController extends Controller
{
    /**
     * @Route("/adminAddQuiz", name="adminAddQuiz")
     */
    public function addQuizAction(Request $request)
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

            return $this->redirectToRoute("adminAddQuestion", array(
                'quizId' => $quiz->getId()
                ));
        }

        return $this->render(
            'admin/adminAddQuiz.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/adminAddQuestion", name="adminAddQuestion")
     */
    public function addQuestionAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $question->setFinishQuestion(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();
            $questionWithId = $em->getRepository(Question::class)->findOneBy(['question' => $question->getQuestion()]);
            $quiz_question = new QuizQuestion();
            $quiz_question->setIdQuiz($request->get('quizId'));
            $quiz_question->setIdQuestion($questionWithId->getId());
            $em->persist($quiz_question);
            $em->flush();

            return $this->redirectToRoute("adminAddAnswers");
        }

        return $this->render(
            'admin/adminAddQuestion.html.twig',
            array('form' => $form->createView())
        );
    }
}