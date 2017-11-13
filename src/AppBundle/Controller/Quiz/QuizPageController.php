<?php

declare(strict_types=1);

namespace AppBundle\Controller\Quiz;

use AppBundle\Entity\Quiz\Answer;
use AppBundle\Entity\Quiz\Question;
use AppBundle\Entity\Quiz\Quiz;
use AppBundle\Entity\Quiz\QuizQuestion;
use AppBundle\Entity\Quiz\UserAnswer;
use AppBundle\Entity\UserTop;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizPageController extends Controller
{
    /**
     * @Route("/userQuizPage", name="userQuizPage")
     */
    public function userQuizPageAction(Request $request)
    {
        $idUser = $request->get('idUser');
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);

        $userAnswer = $em->getRepository(UserAnswer::class)->findOneBy(array('idQuizQuestion' => $quizQuestion[0]->getId(), 'idUser' => $idUser));
        if ($userAnswer != null){

            for ($i = 0; $i < count($quizQuestion); ++$i) {
                if ($quizQuestion[$i] != null) {
                    $userAnswer = $em->getRepository(UserAnswer::class)->findOneBy(array('idQuizQuestion' => $quizQuestion[$i]->getId(), 'idUser' => $idUser));
                    if ($userAnswer == null) {
                        $userAnswer = $em->getRepository(UserAnswer::class)->findOneBy(array('idQuizQuestion' => $quizQuestion[$i - 1]->getId(), 'idUser' => $idUser));
                        break;
                    }
                }
            }
            $question = $em->getRepository(Question::class)->find($quizQuestion[$userAnswer->getWhatQuestion() + 1]->getIdQuestion());
            $answer = $em->getRepository(Answer::class)->find($quizQuestion[$userAnswer->getWhatQuestion() + 1]->getIdAnswer());

            return $this->render('quiz/userQuizPage.html.twig', array(
                'idUser' => $idUser,
                'quizName' => $quizName,
                'idQuizQuestion' => $quizQuestion[$userAnswer->getWhatQuestion()]->getId(),
                'idQuestion' => $question->getId(),
                'idAnswer' => $answer->getId(),
                'idUserAnswer' => $userAnswer->getId(),
                'whatQuestion' => $userAnswer->getWhatQuestion(),
                'countCorrect' => $userAnswer->getCountCorrect(),
                'correctAnswer' => $answer->getCorrect(),
                'question' => $question->getQuestion(),
                'answer1' => $answer->getAnswer1(),
                'answer2' => $answer->getAnswer2(),
                'answer3' => $answer->getAnswer3(),
                'answer4' => $answer->getAnswer4()
            ));
        }

        $question = $em->getRepository(Question::class)->find($quizQuestion[0]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[0]->getIdAnswer());

        return $this->render('quiz/userQuizPage.html.twig', array(
            'idUser' => $idUser,
            'quizName' => $quizName,
            'idQuizQuestion' => $quizQuestion[0]->getId(),
            'idQuestion' => $question->getId(),
            'idAnswer' => $answer->getId(),
            'idUserAnswer' => null,
            'whatQuestion' => 0,
            'countCorrect' => 0,
            'correctAnswer' => $answer->getCorrect(),
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
        $countCorrect = $request->get('countCorrect');
        $idAnswer = $request->get('idAnswer');

        $em = $this->getDoctrine()->getManager();

        $answer = $em->getRepository(Answer::class)->find($idAnswer);

        $userAnswer = new UserAnswer();
        $userAnswer->setIdUser((int)$idUser);
        $userAnswer->setIdQuizQuestion((int)$idQuizQuestion);
        $userAnswer->setWhatQuestion((int)$whatQuestion);

        if ($answer->getCorrect() == $request->get('currentAnswer')){
            $countCorrect = $countCorrect + 1;
        }
        $userAnswer->setCountCorrect((int)$countCorrect);

        $em->persist($userAnswer);
        $em->flush();

        if ($request->get('format') == 'json'){
            $response = new Response(json_encode(array('whatQuestion' => $request->get('whatQuestion') + 1)));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $this->render('quiz/userQuizPage.html.twig', array(
        'idUser' => $idUser,
        'quizName' => $request->get('quizName'),
        'idQuizQuestion' => $idQuizQuestion,
        'idQuestion' => $request->get('idQuestion'),
        'idAnswer' => $request->get('idAnswer'),
        'idUserAnswer' => $userAnswer->getId(),
        'whatQuestion' => $whatQuestion + 1,
        'countCorrect' => $countCorrect,
        'correctAnswer' => $answer->getCorrect(),
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
        $whatQuestion = $request->get('whatQuestion');
        $quizName = $request->get('quizName');

        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);

        if ($quiz->getFinishQuestion() == $whatQuestion){
            $userTop = new UserTop();
            $userTop->setQuizName($request->get('quizName'));
            $userTop->setIdUser($request->get('idUser'));
            $userTop->setCountPoints($request->get('countCorrect'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($userTop);
            $em->flush();
            return $this->render('quiz/userFinishQuiz.html.twig', array(
                'quiz' => $quiz,
                'countCorrect' => $request->get('countCorrect'),
            ));

        }
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[$whatQuestion]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[$whatQuestion]->getIdAnswer());

        if ($request->get('format') == 'json'){
            $response = new Response(json_encode(array('whatQuestion' => $request->get('whatQuestion'))));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $this->render('quiz/userQuizPage.html.twig', array(
            'idUser' => $request->get('idUser'),
            'quizName' => $quizName,
            'idQuizQuestion' => $quizQuestion[$whatQuestion]->getId(),
            'idQuestion' => $question->getId(),
            'idAnswer' => $answer->getId(),
            'idUserAnswer' => $request->get('idUserAnswer'),
            'whatQuestion' => $whatQuestion ,
            'countCorrect' => $request->get('countCorrect'),
            'correctAnswer' => $answer->getCorrect(),
            'question' => $question->getQuestion(),
            'answer1' => $answer->getAnswer1(),
            'answer2' => $answer->getAnswer2(),
            'answer3' => $answer->getAnswer3(),
            'answer4' => $answer->getAnswer4()
        ));
    }
}
