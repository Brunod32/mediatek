<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NewPwdType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Request;


#[Route('/user')]
class NewPwdController extends AbstractController
{
    #[Route('/newpwd/{id}', name: 'app_new_pwd')]
    public function newPwd(
        User $user,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher, 
        EntityManagerInterface $entityManager
    ): Response
    
    {
        $form = $this->createForm(NewPwdType::class, $user);
        $form->handleRequest($request);

        //Check if from is Submit and valid
        $plainPassword = $form->get('password')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $plainPassword,
                )
            );

            // Save new password
            $entityManager->flush();

            // Redirect to validation page
            return $this->redirectToRoute('app_new_password_validated');
        }

        return $this->render('newPwd/newPwd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/newpassword-validated', name: 'app_new_password_validated', methods: 'GET')]
    public function newPasswordValidated(): Response
    {
        return $this->render('newPwd/validatedPwd.html.twig', []);
    }
}
