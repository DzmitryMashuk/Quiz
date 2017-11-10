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
use AppBundle\Form\AnswerType;
use AppBundle\Entity\Quiz\Answer;

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
            $quiz->setLeaderFirst(0);
            $quiz->setLeaderSecond(0);
            $quiz->setLeaderThird(0);
            $quiz->setStatus(false);
            $quiz->setBlock(false);
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

            return $this->redirectToRoute("adminAddAnswers", array(
                'questionId' => $questionWithId->getId(),
                'quizId' => $request->get('quizId')
            ));
        }

        return $this->render(
            'admin/adminAddQuestion.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/adminAddAnswers", name="adminAddAnswers")
     */
    public function answerAction(Request $request)
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setIdQuestion($request->get('questionId'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            return $this->redirectToRoute("adminAddQuestion", array(
                'quizId' => $request->get('quizId')
            ));
        }

        return $this->render(
            'admin/adminAddAnswers.html.twig',
            array('form' => $form->createView())
        );
    }
}