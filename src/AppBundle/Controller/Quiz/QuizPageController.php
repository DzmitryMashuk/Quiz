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
use Symfony\Component\Validator\Constraints\DateTime;

class QuizPageController extends Controller
{
    /**
     * @Route("/userQuizPage", name="userQuizPage")
     */
    public function userQuizPageAction(Request $request)
    {
        $userId = $request->get('idUser');
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();
        $userAnswer = $em->getRepository(UserAnswer::class)->findBy(['idUser' => $request->get('idUser')]);
        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->findOneBy(['id' => $quizQuestion[0]->getIdQuestion()]);
        $answer = $em->getRepository(Answer::class)->findOneBy(['idQuestion' => $question->getId()]);
        $userAnswerNew = new UserAnswer();
        $userAnswerNew->setIdUser((int)$userId);
        $userAnswerNew->setIdQuizQuestion($quizQuestion[0]->getId());
        $userAnswerNew->setIdAnswer(1);
        $userAnswerNew->setWhatQuestion(2);
        $userAnswerNew->setCountCorrect(0);

        $em->persist($userAnswerNew);
        $em->flush();

        return $this->render('quiz/userQuizPage.html.twig', array(
            'idUser' => $userId,
            'quizName' => $quizName,
            'lastIdUserAnswer' => $userAnswerNew->getWhatQuestion()
        ));
    }
}
