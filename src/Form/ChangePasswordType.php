<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class ,[
                'disabled' => true ,
                'label' => 'Email'
            ])
            ->add('firstname', TextType::class,[
                'disabled' => true ,
                'label' => 'Nom'
            ])
            ->add('lastname', TextType::class,[
                'disabled' => true ,
                'label' => 'Prénom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped'=> false,
                'attr'=>[
                    'placeholder' => 'Veuiller saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password',RepeatedType::class,[
                'type'=> PasswordType::class,
                'mapped'=> false,
                'invalid_message'=>'Les mots de passes doivent etre identiques',
                'required'=> true,
                'first_options'=> [
                    'label'=> 'Nouveau mot de passe',
                    'attr'=>['placeholder'=>'Saisir votre nouveau mot de passe ']
                ],
                'second_options'=>[
                    'label'=> 'Confirmer le nouveau mot de passe',
                    'attr'=>['placeholder'=>'Saisir à nouveau le nouveau mot de passe ']
                    ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>"Mettre à jour"
            ])
        ;
    }
 
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
