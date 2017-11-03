<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\User;
use AppBundle\Form\PasswordRecoveryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;

class PasswordRecoveryController extends Controller
{
    /**
     * @Route("/passwordRecovery", name="passwordRecovery")
     */
    public function showAction($productId)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($productId);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id ' . $productId
            );
        }
    }
}