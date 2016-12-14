<?php
/**
 * Created by PhpStorm.
 * User: Martis
 * Date: 2016-12-10
 * Time: 15:27
 */

namespace AppBundle\Form\Type;

use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Publishers;

class PublisherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('adress')
            ->add('city')
            ->add('postCode')
            ->add('phone');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Publishers',
        ]);
    }
}