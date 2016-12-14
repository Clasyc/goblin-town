<?php
/**
 * Created by PhpStorm.
 * User: Martis
 * Date: 2016-12-10
 * Time: 15:05
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('isbnCode', null, array('label' => 'ISBN kodas'))
            ->add('title', null, array('label' => 'Pavadinimas'))
            ->add('year', DateType::class, array('label' => 'Metai'))
            ->add('pageCount', null, array('label' => 'Puslapių skaičius'))
            ->add('ordered', null, array('label' => 'Ar užsakyta'))
            ->add('fkLanguage', EntityType::class, array(
                'label' => 'Kalba',
                'class' => 'AppBundle:Languages',
                'choice_label' => 'language'
            ))
            ->add('fkGenre', EntityType::class, array(
                'label' => 'Zanras',
                'class' => 'AppBundle:Genres',
                'choice_label' => 'genre'
            ))
            ->add('fkAuthor', EntityType::class, array(
                'label' => 'Autorius',
                'class' => 'AppBundle:Authors',
                'choice_label' => 'name'
            ))
            ->add('fkPublisher', EntityType::class, array(
                'label' => 'Leidykla',
                'class' => 'AppBundle:Publishers',
                'choice_label' => 'name'
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Books',
        ]);
    }
}