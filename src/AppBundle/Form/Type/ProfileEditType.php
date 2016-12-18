<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 10/08/2016
 * Time: 17:49
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Persons;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProfileEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array("label" => "Prisijungimo vardas",))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'first_options' => array('label' => 'Slaptažodis'),
                'second_options' => array('label' => 'Pakartokite slaptažodį'),
                'invalid_message' => 'Slaptažodžiai nesutampa!',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\FosUser',
            'validation_groups' => array('Fosuser'),
        ]);
    }
}