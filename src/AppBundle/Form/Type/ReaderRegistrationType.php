<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 10/08/2016
 * Time: 17:49
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;


class ReaderRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array("label" => "Vardas"))
            ->add('lastName', null, array("label" => "Pavardė"))
            ->add('email', null, array("label" => "El.paštas"))
            ->add('phoneNumber', null, array("label" => "Telefono numeris"))
            ->add('city', null, array("label" => "Miestas"))
            ->add('adress', null, array("label" => "Adresas"))
            ->add('fosuser', ProfileEditType::class, array(
                "label" => false,
                'error_bubbling' => false
                ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Readers',
        ]);
    }
}