<?php

namespace App\Form;
use App\Entity\TypeJobs;
use App\Entity\Experience;
use App\Data\SearchData;
use App\Entity\Skills;
use App\Entity\Jobs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', EntityType::class, [
                'class' => Jobs::class,
                 'label' => false ,
            'required' => false ,
                'choice_label' => 'title',
 'multiple' => true,
                'placeholder' => 'Select',
             
            ])
            ->add('TypeJobs', EntityType::class , [
            'label' => false ,
            'required' => false ,
            'class' => TypeJobs::class,
            'multiple' => true

       ]) 
          ->add('Experience', EntityType::class , [
            'label' => false ,
            'required' => false ,
            'class' => Experience::class,
            'multiple' => true


            
       ])
           ->add('Skills', EntityType::class , [
            'label' => false ,
            'required' => false ,
            'class' => Skills::class,
            'multiple' => true

            
       ])
                ->add('startdate', DateType::class, [
    
    
    'attr' => ['class' => 'js-datepicker'],
    'label' => false ,
     'format' => 'ddMMyyyy',
 'required' => true ,
    'input' => 'string',
    'input_format' => 'Y-m-d' // ajouté en 4.3
])
                   ->add('enddate', DateType::class, [
    
   
    'attr' => ['class' => 'js-datepicker'],
    'label' => false ,
    'format' => 'ddMMyyyy',
    'required' => true ,
    'input' => 'string'])
            ;
    }



   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }


    public function getblockPrefix()

    {
       return '' ;

    }
}
