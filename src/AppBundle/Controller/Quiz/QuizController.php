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

            return $this->redirectToRoute("adminAddAnswers", array(
                'questionId' => $question->getId(),
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
            $em = $this->getDoctrine()->getManager();
            $em->persist($answer);
            $em->flush();

            $quiz_question = new QuizQuestion();
            $quiz_question->setIdQuiz($request->get('quizId'));
            $quiz_question->setIdQuestion($request->get('questionId'));
            $quiz_question->setIdAnswer($answer->getId());
            $em->persist($quiz_question);
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



    /**
     * @Route("/adminEditQuiz", name="AdminEditQuiz")
     */
    public function userQuizPageAction(Request $request)
    {
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[0]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[0]->getIdAnswer());

        return $this->render('admin/adminEditQuiz.html.twig', array(
            'idUser' => $request->get('idUser'),
            'quizName' => $quizName,
            'idQuizQuestion' => $quizQuestion[0]->getId(),
            'idQuestion' => $question->getId(),
            'idAnswer' => $answer->getId(),
            'idUserAnswer' => null,
            'whatQuestion' => 0,
            'question' => $question->getQuestion(),
            'answer1' => $answer->getAnswer1(),
            'answer2' => $answer->getAnswer2(),
            'answer3' => $answer->getAnswer3(),
            'answer4' => $answer->getAnswer4(),
            'correct' => $answer->getCorrect()
        ));


    }


//
//    /**
//     * @Route("/userAnswerWrite", name="userAnswerWrite")
//     */
//    public function userAnswerWriteAction(Request $request)
//    {
//        $idUser = $request->get('idUser');
//        $idQuizQuestion = $request->get('idQuizQuestion');
//        $whatQuestion = $request->get('whatQuestion');
//
//        $userAnswer = new UserAnswer();
//        $userAnswer->setIdUser($idUser);
//        $userAnswer->setIdQuizQuestion($idQuizQuestion);
//        $userAnswer->setWhatQuestion($whatQuestion);
//        $userAnswer->setCountCorrect($request->get('currentAnswer'));
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($userAnswer);
//        $em->flush();
//
//        return $this->render('quiz/userQuizPage.html.twig', array(
//            'idUser' => $idUser,
//            'quizName' => $request->get('quizName'),
//            'idQuizQuestion' => $idQuizQuestion,
//            'idQuestion' => $request->get('idQuestion'),
//            'idAnswer' => $request->get('idAnswer'),
//            'idUserAnswer' => $userAnswer->getId(),
//            'whatQuestion' => $whatQuestion,
//            'question' => $request->get('question'),
//            'answer1' => $request->get('answer1'),
//            'answer2' => $request->get('answer2'),
//            'answer3' => $request->get('answer3'),
//            'answer4' => $request->get('answer4')
//        ));
//    }
//
//    /**
//     * @Route("/nextQuizPage", name="nextQuizPage")
//     */
//    public function nextQuizPageAction(Request $request)
//    {
//        $whatQuestion = $request->get('whatQuestion') + 1;
//        $quizName = $request->get('quizName');
//        $idUserAnswer = $request->get('idUserAnswer');
//        $em = $this->getDoctrine()->getManager();
//
//        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
//        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
//        $question = $em->getRepository(Question::class)->find($quizQuestion[$whatQuestion]->getIdQuestion());
//        $answer = $em->getRepository(Answer::class)->find($quizQuestion[$whatQuestion]->getIdAnswer());
//
//        return $this->render('quiz/userQuizPage.html.twig', array(
//            'idUser' => $request->get('idUser'),
//            'quizName' => $quizName,
//            'idQuizQuestion' => $quizQuestion[$whatQuestion]->getId(),
//            'idQuestion' => $question->getId(),
//            'idAnswer' => $answer->getId(),
//            'idUserAnswer' => $request->get('idUserAnswer'),
//            'whatQuestion' => $whatQuestion,
//            'question' => $question->getQuestion(),
//            'answer1' => $answer->getAnswer1(),
//            'answer2' => $answer->getAnswer2(),
//            'answer3' => $answer->getAnswer3(),
//            'answer4' => $answer->getAnswer4()
//        ));
//    }
}