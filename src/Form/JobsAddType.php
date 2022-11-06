<?php

namespace App\Form;

use App\Entity\Jobs;
use App\Entity\TypeJobs;
use App\Entity\Skills;
use App\Entity\Experience;
use App\Repository\TypeJobsRepository;
use App\Repository\SkillsRepository;
use App\Repository\ExperienceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


use Symfony\Component\Form\Extension\Core\Type\ImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class JobsAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('title', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])



    

        ->add('city', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

    ->add('country', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('typeid', EntityType::class, [
                'class' => TypeJobs::class,
                'choice_label' => 'title',

                'placeholder' => 'Select',
             
            ])
            ->add('Skills', EntityType::class , [
            
            'required' => true ,
            'class' => Skills::class,
            'multiple' => true


        
            
       ])
                ->add('exp', EntityType::class, [
                'class' => Experience::class,
                'choice_label' => 'title',
                'placeholder' => 'Select',
              
            ])
        
                 ->add('presentation', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
                
            ])

                    ->add('resp', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
                
            ])
                       ->add('req', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
                
            ])
                         ->add('ExpiredAt', dateType::class, [
                "attr" => [
                    "class" => "js-datepicker",
                     'html5' => false,
                   
                   
                ]

            ])
                       

                ->add('imagefield', FileType::class, [
                'mapped' => false,
                'required'=>false
            ])
                 ->add('image', HiddenType::class, [
                
            ])
              
                 ->add('coverfield', FileType::class, [
                'mapped' => false,
                'required'=>false,
              
            ])
                 ->add('cover', HiddenType::class, [
                
            ])
                

                  
               
            
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Jobs::class,
        ]);

        
    }
}
