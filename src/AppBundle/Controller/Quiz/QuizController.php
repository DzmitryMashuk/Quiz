<?php

declare(strict_types=1);

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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
            $quiz->setFinishQuestion(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute("adminAddQuestion", array(
                'quizId' => $quiz->getId(),
                'countQuestion' => 0
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute("adminAddAnswers", array(
                'questionId' => $question->getId(),
                'quizId' => $request->get('quizId'),
                'countQuestion' => $request->get('countQuestion') + 1
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $quiz_question = new QuizQuestion();
            $quiz_question->setIdQuiz($request->get('quizId'));
            $quiz_question->setIdQuestion($request->get('questionId'));
            $quiz_question->setIdAnswer($answer->getId());
            $em->persist($quiz_question);

            $quizId = $request->get('quizId');
            $countQuestion = $request->get('countQuestion');
            $quiz = $em->getRepository(Quiz::class)->find($quizId);
            $quiz->setFinishQuestion($countQuestion);
            $em->persist($quiz);

            $em->flush();

            return $this->redirectToRoute("adminAddQuestion", array(
                'quizId' => $quizId,
                'countQuestion' => $countQuestion
            ));
        }

        return $this->render(
            'admin/adminAddAnswers.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/adminDeleteQuiz", name="adminDeleteQuiz")
     */
    public function deleteQuizAction(Request $request)
    {
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $em->remove($quiz);
        $em->flush();
        $quizAll = $em->getRepository(Quiz::class)->findAll();


        return $this->render('mainMenu/adminMainMenu.html.twig', array(
            'quiz' => $quizAll
        ));
    }

    /**
     * @Route("/userFinishQuiz", name="userFinishQuiz")
     */
    public function userFinishQuizAction(Request $request)
    {
        return $this->render('quiz/userFinishQuiz.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     *
     * @Route("/userFinishQuiz", name="userFinishQuiz")
     * @Method("GET")
     */
    public function userQuizFinishAction()
    {
        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository(Quiz::class)->findOneById(46);
        return $this->render('quiz/userFinishQuiz.html.twig', array(
            'quiz' => $quiz,
        ));
    }
}