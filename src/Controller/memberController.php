<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\membersType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class memberController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     */
    public function index(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('members/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);

    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

        /**
         * @Route("/register", name="app_register")
         */
        public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(membersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password

            // ... e.g. get the user data from a registration form
            $user = new User();
            $plaintextPassword = $form->get('password')->getData();
            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );

            $user->setPassword($hashedPassword);
            $user->setEmail($form->get('email')->getData());
            $user->setFirstname($form->get('firstname')->getData());
            $user->setFirstname($form->get('name')->getData());

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirect('members/register.html.twig');
        }

        return $this->render('members/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
