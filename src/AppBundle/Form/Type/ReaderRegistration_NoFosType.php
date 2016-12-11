<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 10/08/2016
 * Time: 17:49
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class ReaderRegistration_NoFosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', null, array("label" => false))
            ->add('lastName', null, array("label" => false))
            ->add('email', null, array("label" => false))
            ->add('phoneNumber', null, array("label" => false))
            ->add('city', null, array("label" => false))
            ->add('adress', null, array("label" => false))
            ->add('save', ButtonType::class, array(
                'label' => 'Redaguoti',
                'attr' => array('class' => 'btn btn-primary', 'onclick' => '$(this).closest(\'form\').submit();'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Readers',
        ]);
    }
}