<?php

namespace AppBundle\Controller\Quiz;

use AppBundle\Entity\Quiz\Answer;
use AppBundle\Entity\Quiz\Question;
use AppBundle\Entity\Quiz\Quiz;
use AppBundle\Entity\Quiz\QuizQuestion;
use AppBundle\Entity\Quiz\UserAnswer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuizPageController extends Controller
{
    /**
     * @Route("/userQuizPage", name="userQuizPage")
     */
    public function userQuizPageAction(Request $request)
    {
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[0]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[0]->getIdAnswer());

        return $this->render('quiz/userQuizPage.html.twig', array(
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
        ));
    }

    /**
     * @Route("/userAnswerWrite", name="userAnswerWrite")
     */
    public function userAnswerWriteAction(Request $request)
    {
        $idUser = $request->get('idUser');
        $idQuizQuestion = $request->get('idQuizQuestion');
        $whatQuestion = $request->get('whatQuestion');

        $userAnswer = new UserAnswer();
        $userAnswer->setIdUser($idUser);
        $userAnswer->setIdQuizQuestion($idQuizQuestion);
        $userAnswer->setWhatQuestion($whatQuestion);
        $userAnswer->setCountCorrect($request->get('currentAnswer'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($userAnswer);
        $em->flush();

        return $this->render('quiz/userQuizPage.html.twig', array(
        'idUser' => $idUser,
        'quizName' => $request->get('quizName'),
        'idQuizQuestion' => $idQuizQuestion,
        'idQuestion' => $request->get('idQuestion'),
        'idAnswer' => $request->get('idAnswer'),
        'idUserAnswer' => $userAnswer->getId(),
        'whatQuestion' => $whatQuestion,
        'question' => $request->get('question'),
        'answer1' => $request->get('answer1'),
        'answer2' => $request->get('answer2'),
        'answer3' => $request->get('answer3'),
        'answer4' => $request->get('answer4')
        ));
    }

    /**
     * @Route("/nextQuizPage", name="nextQuizPage")
     */
    public function nextQuizPageAction(Request $request)
    {
        $whatQuestion = $request->get('whatQuestion') + 1;
        $quizName = $request->get('quizName');
        $idUserAnswer = $request->get('idUserAnswer');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[$whatQuestion]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[$whatQuestion]->getIdAnswer());

        return $this->render('quiz/userQuizPage.html.twig', array(
            'idUser' => $request->get('idUser'),
            'quizName' => $quizName,
            'idQuizQuestion' => $quizQuestion[$whatQuestion]->getId(),
            'idQuestion' => $question->getId(),
            'idAnswer' => $answer->getId(),
            'idUserAnswer' => $request->get('idUserAnswer'),
            'whatQuestion' => $whatQuestion,
            'question' => $question->getQuestion(),
            'answer1' => $answer->getAnswer1(),
            'answer2' => $answer->getAnswer2(),
            'answer3' => $answer->getAnswer3(),
            'answer4' => $answer->getAnswer4()
        ));
    }
}
