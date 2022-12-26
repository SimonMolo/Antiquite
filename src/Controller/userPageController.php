<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;

class userPageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(){
        return $this->render("user/home.html.twig");
    }

    /**
     * @Route ("/bienvenue", name="membersHome")
     */
    public function membresHome(){
        return $this->render("members/membersHome.html.twig");
    }
}

