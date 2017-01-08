<?php
/**
 * Created by PhpStorm.
 * User: Martis
 * Date: 2016-12-10
 * Time: 15:05
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Languages;
use AppBundle\Entity\Genres;
use AppBundle\Entity\Publishers;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use \DateTime;

class BooksType extends AbstractType
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('isbnCode', null, array('label' => 'ISBN kodas',
                'attr' => array('style' => 'width: 170px')))
            ->add('title', null, array('label' => 'Pavadinimas'))
            ->add('year', DateType::class, array(
                'label' => 'Metai',
                'years' => range(date('Y'), date('Y') - 100)
            ))
            ->add('pageCount', null, array('label' => 'Puslapių skaičius',
                'attr' => array('style' => 'width: 150px')
            ))
            ->add('ordered', null, array('label' => 'Ar užsakyta:'))
            ->add('fkLanguage', EntityType::class, array(
                'label' => 'Kalba',
                'class' => 'AppBundle:Languages',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.language', 'ASC');
                },
                'choice_label' => 'language'
            ));

            $builder->add('languageNew', TextType::class, array(
                'label' => 'Pridėti kalbą',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkLanguage'
            ));

            $builder->add('fkGenre', EntityType::class, array(
                'label' => 'Žanras',
                'class' => 'AppBundle:Genres',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.genre', 'ASC');
                },
                'choice_label' => 'genre'
            ));

            $builder->add('genreNew', TextType::class, array(
                'label' => 'Pridėti žanrą',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkGenre'
            ));

            $builder->add('fkAuthor', EntityType::class, array(
                'label' => 'Autorius',
                'class' => 'AppBundle:Authors',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => 'lastName'
            ));

            $builder->add('authorNameNew', TextType::class, array(
                'label' => 'Autoriaus vardas',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkAuthor',
            ))
                ->add('authorLastNameNew', TextType::class, array(
                    'label' => 'Autoriaus pavarde',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkAuthor',
                ))
                ->add('authorNationalityNew', TextType::class, array(
                    'label' => 'Autoriaus tautybe',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkAuthor',
                ))
                ->add('authorBDayNew', DateType::class, array(
                    'label' => 'Autoriaus gimimo data',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkAuthor',
                    'years' => range(date('Y'), date('Y') - 100)
                    ))
                ->add('authorDDayNew', DateType::class, array(
                    'label' => 'Autoriaus mirties data',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkAuthor',
                    'years' => range(date('Y'), date('Y') - 100)
                ));

            $builder ->add('fkPublisher', EntityType::class, array(
                'label' => 'Leidykla',
                'class' => 'AppBundle:Publishers',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name'
            ));

            $builder->add('publisherNameNew', TextType::class, array(
                'label' => 'Leidyklos pavadinimas',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkPublisher',
            ))
            ->add('publisherAdressNew', TextType::class, array(
                'label' => 'Leidyklos adresas',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkPublisher',
            ))
            ->add('publisherCityNew', TextType::class, array(
                'label' => 'Leidyklos miestas',
                'required' => FALSE,
                'mapped' => FALSE,
                'property_path' => 'fkPublisher',
            ))
                ->add('publisherPostCodeNew', TextType::class, array(
                    'label' => 'Leidyklos pasto adresas',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkPublisher',
                ))
                ->add('publisherPhoneNew', TextType::class, array(
                    'label' => 'Leidyklos telefono Nr.',
                    'required' => FALSE,
                    'mapped' => FALSE,
                    'property_path' => 'fkPublisher',
                ));


        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!empty($data['languageNew'])) {

                $newLanguage = new Languages();
                $newLanguage->setLanguage($data['languageNew']);

                $temp = $this->em->getRepository("AppBundle:Languages")->findOneBy(array("language" => $data['languageNew']));

                if(empty($temp)){
                    $this->em->persist($newLanguage);
                    $this->em->flush();
                    $insert = $newLanguage->getId();
                }else{
                    $insert = $temp->getId();
                }

                $data['fkLanguage'] = $insert;
                $event->setData($data);

            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!empty($data['genreNew'])) {

                $newGenre = new Genres();
                $newGenre->setGenre($data['genreNew']);

                $temp = $this->em->getRepository("AppBundle:Genres")->findOneBy(array("genre" => $data['genreNew']));

                if(empty($temp)){
                    $this->em->persist($newGenre);

                    $this->em->flush();
                    $insert = $newGenre->getId();
                }else{
                    $insert = $temp->getId();
                }

                $data['fkGenre'] = $insert;
                $event->setData($data);
            }
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();


            if (!empty($data['authorNameNew'])) {

                $newAuthor = new Authors();
                $newAuthor->setName($data['authorNameNew']);
                $newAuthor->setLastName($data['authorLastNameNew']);
                $newAuthor->setNationality($data['authorNationalityNew']);
                $newAuthor->setBirthDate(new \DateTime(implode('-',$data['authorBDayNew'])));
                $DDate = true;
                foreach($data['authorDDayNew'] as $key=>$var){
                    if(empty($var))
                        $DDate = false;
                }

                if($DDate)
                    $newAuthor->setDeathDate(new \DateTime(implode('-',$data['authorDDayNew'])));
                else
                    $newAuthor->setDeathDate(NULL);



                $temp = $this->em->getRepository("AppBundle:Authors")->findOneBy(array("lastName" => $data['authorLastNameNew']));
                if(empty($temp)){
                    $this->em->persist($newAuthor);

                    $this->em->flush();

                    $insert = $newAuthor->getId();
                }else{
                    $insert = $temp->getId();
                }

                $data['fkAuthor'] = $insert;
                $event->setData($data);
            }
        });


        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();


            if (!empty($data['publisherNameNew'])) {

                $newPublisher = new Publishers();
                $newPublisher->setName($data['publisherNameNew']);
                $newPublisher->setAdress($data['publisherAdressNew']);
                $newPublisher->setCity($data['publisherCityNew']);
                $newPublisher->setPostCode($data['publisherPostCodeNew']);
                $newPublisher->setPhone($data['publisherPhoneNew']);

                $temp = $this->em->getRepository("AppBundle:Publishers")->findOneBy(array("name" => $data['publisherNameNew']));
                if(empty($temp)){
                    $this->em->persist($newPublisher);
                    //dump($data);die();
                    $this->em->flush();

                    $insert = $newPublisher->getId();
                }else{
                    $insert = $temp->getId();
                }

                $data['fkPublisher'] = $insert;
                $event->setData($data);
            }
        });

        $builder->add('Saugoti', SubmitType::class);

    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Books',
        ]);
    }
}