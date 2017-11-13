<?php

declare(strict_types=1);

namespace AppBundle\Controller\Quiz;

use AppBundle\Entity\Quiz\QuizQuestion;
use AppBundle\Entity\UserTop;
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
     * @Route("/adminEditQuiz", name="adminEditQuiz")
     */
    public function adminEditQuizAction(Request $request)
    {
        $quizName = $request->get('quizName');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[0]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[0]->getIdAnswer());

        return $this->render('admin/adminEditQuiz.html.twig', array(
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

    /**
     * @Route("/adminChangeQuiz", name="adminChangeQuiz")
     */
    public function adminChangeQuizAction(Request $request)
    {
        $quizName = $request->get('quizName');
        $whatQuestion =$request->get('whatQuestion');
        $em = $this->getDoctrine()->getManager();

        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);
        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[$whatQuestion]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[$whatQuestion]->getIdAnswer());

        $question->setQuestion($request->get('question'));
        $answer->setAnswer1($request->get('answer1'));
        $answer->setAnswer2($request->get('answer2'));
        $answer->setAnswer3($request->get('answer3'));
        $answer->setAnswer4($request->get('answer4'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($answer);
        $em->flush();

        return $this->render('admin/adminEditQuiz.html.twig', array(
            'question' => $question->getQuestion(),
            'whatQuestion' => $whatQuestion + 1,
            'answer1' => $answer->getAnswer1(),
            'answer2' => $answer->getAnswer2(),
            'answer3' => $answer->getAnswer3(),
            'answer4' => $answer->getAnswer4(),
            'correct' => $answer->getCorrect(),
            'quizName' => $quizName
        ));
    }

    /**
     * @Route("/nextEditQuiz", name="nextEditQuiz")
     */
    public function nextEditQuizAction(Request $request)
    {

        $whatQuestion = $request->get('whatQuestion');
        $quizName = $request->get('quizName');

        $em = $this->getDoctrine()->getManager();
        $quiz = $em->getRepository(Quiz::class)->findOneBy(['name' => $quizName]);

        if ($quiz->getFinishQuestion() == $whatQuestion){
            $quizAll = $em->getRepository(Quiz::class)->findAll();
            return $this->render('mainMenu/adminMainMenu.html.twig', array(
                'quiz' => $quizAll,
                'quizName'=> $quizName,
                'countCorrect' => $request->get('countCorrect'),
            ));

        }


        $quizQuestion = $em->getRepository(QuizQuestion::class)->findBy(['idQuiz' => $quiz->getId()]);
        $question = $em->getRepository(Question::class)->find($quizQuestion[$whatQuestion]->getIdQuestion());
        $answer = $em->getRepository(Answer::class)->find($quizQuestion[$whatQuestion]->getIdAnswer());

        return $this->render('admin/adminEditQuiz.html.twig', array(
            'quizName' => $quizName,
            'idQuizQuestion' => $quizQuestion[$whatQuestion]->getId(),
            'idQuestion' => $question->getId(),
            'idAnswer' => $answer->getId(),
            'idUserAnswer' => null,
            'whatQuestion' => $whatQuestion,
            'question' => $question->getQuestion(),
            'answer1' => $answer->getAnswer1(),
            'answer2' => $answer->getAnswer2(),
            'answer3' => $answer->getAnswer3(),
            'answer4' => $answer->getAnswer4(),
            'correct' => $answer->getCorrect(),
        ));
    }
}