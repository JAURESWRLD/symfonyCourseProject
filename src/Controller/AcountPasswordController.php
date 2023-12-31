<?php

namespace App\Controller;


use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\DecoderInterface;

class AcountPasswordController extends AbstractController
{
    private $entityManager;
    public function __construct( EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/modification-de-mot-de-passe', name: 'app_acount_password')]
    public function index(Request $request , UserPasswordHasherInterface $hasher, DecoderInterface $decoder): Response
    {

        $notification= null;
        $user= $this->getUser();
        $form= $this->createForm( ChangePasswordType::class, $user);

        
        $form->handleRequest($request); 

        if( $form->isSubmitted() && $form->isValid() ){
            $old_pwd= $form->get('old_password')->getData();
            
            if($hasher->isPasswordValid($user, $old_pwd)){
                $new_pwd=$form->get('new_password')->getData();
                $password=$hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);
                $this->entityManager->flush();
                $notification=" Votre mot de passe à bien été mise à jour";
            }else{
                $notification ="Erreur de modification veuillez réessayer";
            }

        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification

        ]);
    }
}
