<?php
/**
 * Created by PhpStorm.
 * User: Martis
 * Date: 2016-12-10
 * Time: 15:05
 */

namespace AppBundle\Form\Type;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Authors;


class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array("label" => "Vardas"))
            ->add('lastname', null, array("label" => "Pavarde"))
            ->add('nationality', null, array("label" => "Tautybe"))
            ->add('birthDate', null, array("label" => "Gimimo data"))
            ->add('deathDate', null, array("label" => "Mirties data"));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Authors',
        ]);
    }
}