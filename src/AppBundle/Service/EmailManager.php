<?php

namespace AppBundle\Service;

class EmailManager
{
    public static function sendMail(\Swift_Mailer $mailer, string $email, string $body)
     {
         $message = (new \Swift_Message('QUIZ'))
             ->setFrom('DzmitryMashuk@gmail.com')
             ->setTo($email)
             ->setBody($body, 'text/html')
         ;

         $mailer->send($message);
     }
}