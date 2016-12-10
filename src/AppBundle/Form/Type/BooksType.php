<?php
/**
 * Created by PhpStorm.
 * User: Martis
 * Date: 2016-12-10
 * Time: 15:05
 */

namespace AppBundle\Form\Type;

use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Authors;

class BooksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isbnCode')
            ->add('title')
            ->add('year')
            ->add('pageCount')
            ->add('ordered')
            ->add('fkLanguage', EntityType::class, array(
                'label' => false,
                'choice_label' => 'zanras'
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Genres',
        ]);
    }
}