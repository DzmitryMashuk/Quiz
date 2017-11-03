<?php

namespace AppBundle\Form;

use AppBundle\Entity\Quiz\Answer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer1', TextType::class)
            ->add('answer2', TextType::class)
            ->add('answer3', TextType::class)
            ->add('answer4', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Answer::class,
        ));
    }
}